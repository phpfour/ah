<?php

namespace App\Transformers;

use App\Presenters\JobPresenter;
use Elastica\Result;
use Elastica\Document;
use Illuminate\Database\Eloquent\Model;

class JobTransformer implements TransformerInterface
{
    protected $mapping = [
        'jobtitle'    => 'title',
        'description' => 'description',
        'job_company' => 'company'
    ];

    /**
     * {@inheritDoc}
     */
    public function toDocument(Model $model, Document $document)
    {
        foreach ($this->mapping as $field => $key) {
            $document->set($key, $model->$field);
        }

        if (!empty($model->job_ziplat) && !empty($model->job_ziplon)) {
            $document->set('location', $model->job_ziplat . ',' . $model->job_ziplon);
        }

        $fullAddress = [];

        if (!empty($model->job_address)) {
            $fullAddress[] = $model->job_address;
        }

        if (!empty($model->city)) {
            $fullAddress[] = $model->city;
        }

        if (!empty($model->job_postcode)) {
            $fullAddress[] = $model->job_postcode;
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

        foreach ($this->mapping as $field => $key) {
            $model->$field = $filtered[$key];
        }

        return $model;
    }

    /**
     * {@inheritDoc}
     */
    public function toPresenter(Result $result, Model $model)
    {
        $toModel = $this->toModel($result, $model);

        $jobPresenter = new JobPresenter($toModel);
        $jobPresenter->setHighlight($result->getHighlights());

        return $jobPresenter;
    }
}