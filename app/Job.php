<?php

namespace App;

use Elasticquent\ElasticquentTrait;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use ElasticquentTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'phpjob_jobs';

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
    protected $mappingProperties = array(
        'jobtitle' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],
        'description' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],
        'job_company' => [
            'type' => 'string',
            "analyzer" => "standard",
        ]
    );
}