<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'phpjob_jobs';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'jobid';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['jobtitle', 'description', 'job_company'];

    /**
     * Elasticsearch mapping
     *
     * @var array
     */
    protected $mappingProperties = [
        'properties' => [
            'title' => [
                'type'     => 'string',
                "analyzer" => "standard",
            ],
            'description' => [
                'type'     => 'string',
                "analyzer" => "standard",
            ],
            'company' => [
                'type'     => 'string',
                "analyzer" => "standard",
            ],
            'full_address' => [
                'type' => 'string'
            ],
            'location' => [
                'type' => 'geo_point',
            ]
        ]
    ];

    public $highlight;

    public function getElasticsearchMapping()
    {
        return $this->mappingProperties;
    }
}