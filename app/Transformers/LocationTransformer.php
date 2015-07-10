<?php

namespace App\Transformers;

use Elastica\Result;
use Elastica\Document;
use App\Presenters\LocationPresenter;
use Illuminate\Database\Eloquent\Model;

/**
 * Location Transformer
 *
 * Transform location entity data between Eloquent and Elasticsearch Document.
 *
 * @author Mohammad Emran Hasan <phpfour@gmail.com>
 */
class LocationTransformer implements TransformerInterface
{
    /**
     * {@inheritDoc}
     */
    public function toDocument(Model $model, Document $document)
    {
        $mapping = [
            'city'     => 'city',
            'state'    => 'state',
            'country'  => 'country',
            'zip_code' => 'zip_code'
        ];

        foreach ($mapping as $field => $key) {
            $document->set($key, $model->$field);
        }

        if (!empty($model->lat) && !empty($model->lon)) {
            $document->set('location', ['lon' => $model->lon, 'lat' => $model->lat]);
        }

        $fullAddress = [];

        if (!empty($model->city)) {
            $fullAddress[] = $model->city;
        }

        if (!empty($model->state)) {
            $fullAddress[] = $model->state;
        }

        if (!empty($model->zip_code)) {
            $fullAddress[] = $model->zip_code;
        }

        if (!empty($model->country)) {
            $fullAddress[] = $model->country;
        }

        $document->set('full_address', implode(', ', $fullAddress));

        return $document;
    }

    /**
     * {@inheritDoc}
     */
    public function toModel(Result $result, Model $model)
    {
        $exclude = [
            'location',
            'full_address'
        ];

        $filtered = array_diff_key($result->getSource(), array_flip($exclude));

        $model->exists = true;
        $model->id = $result->getId();
        $model->fill($filtered);

        return $model;
    }

    /**
     * {@inheritDoc}
     */
    public function toPresenter(Result $result, Model $model)
    {
        $toModel = $this->toModel($result, $model);

        $locationPresenter = new LocationPresenter($toModel);
        $locationPresenter->setHighlight($result->getHighlights());

        return $locationPresenter;
    }
}