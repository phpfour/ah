<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Location Model
 *
 * @author Mohammad Emran Hasan <phpfour@gmail.com>
 */
class Location extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'phpjob_zipcodes';

    /**
     * Elasticsearch mapping
     *
     * @var array
     */
    protected $mappingProperties = [
        '_all'       => [
            "index_analyzer"  => "nGram_analyzer",
            "search_analyzer" => "whitespace_analyzer"
        ],
        'properties' => [
            'city'         => [
                'type' => 'string'
            ],
            'state'        => [
                'type' => 'string'
            ],
            'country'      => [
                'type' => 'string'
            ],
            'zip_code'     => [
                'type' => 'string'
            ],
            'full_address' => [
                'type' => 'string'
            ],
            'location'     => [
                'type' => 'geo_point',
            ]
        ]
    ];

    public function getElasticsearchMapping()
    {
        return $this->mappingProperties;
    }
}