<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
        'properties' => [
            'city' => [
                'type'     => 'string',
                "analyzer" => "standard",
            ],
            'state' => [
                'type'     => 'string',
                "analyzer" => "standard",
            ],
            'country' => [
                'type'     => 'string',
                "analyzer" => "standard",
            ],
            'zip_code' => [
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

    public function getElasticsearchMapping()
    {
        return $this->mappingProperties;
    }
}