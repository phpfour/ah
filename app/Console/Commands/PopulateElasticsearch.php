<?php

namespace App\Console\Commands;

use App\Job;
use App\Location;
use App\Utility\Elastica;
use App\Transformers\JobTransformer;
use App\Transformers\LocationTransformer;

use Illuminate\Console\Command;

/**
 * Populate Elasticsearch
 *
 * Index jobs and locations into Elasticsearch. Supports large volume of documents by
 * handling chunk of documents at one go.
 *
 * @author Mohammad Emran Hasan <phpfour@gmail.com>
 */
class PopulateElasticsearch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'activehire:index {batch} {--force} {--debug}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populates Elasticsearch index with job and location details.';

    /**
     * Elastica Custom Client
     *
     * @var Elastica
     */
    protected $elastica;

    /**
     * @var JobTransformer
     */
    protected $jobTransformer;

    /**
     * @var LocationTransformer
     */
    protected $locationTransformer;

    /**
     * Documents to index
     *
     * @var array
     */
    protected $documents;

    /**
     * Batch size of indexing
     *
     * @var int
     */
    protected $batch = 100;

    /**
     * Force re-index
     *
     * @var bool
     */
    protected $force = false;

    /**
     * Debug message
     *
     * @var bool
     */
    protected $debug = true;

    /**
     * Total number of records to process
     *
     * @var int
     */
    protected $total = 0;

    /**
     * Number of records processed
     *
     * @var int
     */
    protected $processed = 0;

    public function __construct(Elastica $elastica, JobTransformer $jobTransformer, LocationTransformer $locationTransformer)
    {
        parent::__construct();

        $this->elastica = $elastica;
        $this->jobTransformer = $jobTransformer;
        $this->locationTransformer = $locationTransformer;
    }

    public function handle()
    {
        $this->batch = $this->argument('batch');
        $this->force = $this->option('force');
        $this->debug = $this->option('debug');

        $this->prepareIndexAndTypes();
        $this->indexJobs();
        $this->indexLocations();
    }

    private function prepareIndexAndTypes()
    {
        $index = $this->elastica->getIndex('activehire');

        if ($index->exists() && $this->force) {
            $index->delete();
        }

        if (!$index->exists()) {
            $index->create([
                'settings' => [
                    'analysis' => [
                        'analyzer' => [
                            'nGram_analyzer' => [
                                'type' => 'custom',
                                'tokenizer' => 'whitespace',
                                'filter' => ['lowercase', 'asciifolding', 'nGram_filter']
                            ],
                            'whitespace_analyzer' => [
                                'type' => 'custom',
                                'tokenizer' => 'whitespace',
                                'filter' => ['lowercase', 'asciifolding']
                            ]
                        ],
                        'filter' => [
                            'nGram_filter' => [
                                'type' => 'nGram',
                                'min_gram' => 2,
                                'max_gram' => 20,
                                'token_chars' => ['letter', 'digit', 'punctuation', 'symbol']
                            ]
                        ]
                    ]
                ],
                'mappings' => [
                    'jobs'      => (new Job)->getElasticsearchMapping(),
                    'locations' => (new Location())->getElasticsearchMapping()
                ]
            ]);
        }
    }

    private function indexJobs()
    {
        $this->total = Job::all()->count();
        $this->processed = 0;

        $this->write('info', '=== [JOBS] ===');

        Job::chunk($this->batch, function($jobs) {

            $offset = $this->processed;
            $this->processed += count($jobs);

            $documents = [];
            foreach ($jobs as $job) {
                $document = $this->elastica->createDocument([], 'jobs', 'activehire', $job->jobid);
                $document = $this->jobTransformer->toDocument($job, $document);
                $documents[] = $document;
            }

            $this->elastica->addDocuments($documents);
            $this->write('info', 'Indexed jobs from ' . $offset . ' to ' . $this->processed . ' (' . floor(($this->processed / $this->total) * 100) . '%).');

        });

        $this->write('info', '=== [/JOBS] ===');
    }

    private function indexLocations()
    {
        $this->total = Location::all()->count();
        $this->processed = 0;

        $this->write('info', '=== [LOCATIONS] ===');

        Location::chunk($this->batch, function($locations) {

            $offset = $this->processed;
            $this->processed += count($locations);

            $documents = [];
            foreach ($locations as $location) {
                $document = $this->elastica->createDocument([], 'locations', 'activehire', $location->id);
                $document = $this->locationTransformer->toDocument($location, $document);
                $documents[] = $document;
            }

            $this->elastica->addDocuments($documents);
            $this->write('info', 'Indexed locations from ' . $offset . ' to ' . $this->processed . ' (' . floor(($this->processed / $this->total) * 100) . '%).');

        });

        $this->write('info', '=== [/LOCATIONS] ===');
    }

    protected function write($type, $message)
    {
        if ($this->debug) {
            $this->comment('[' . date('Y-m-d H:i:s') . "] <{$type}>{$message}</{$type}>");
        }
    }
}