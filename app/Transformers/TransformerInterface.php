<?php

namespace App\Transformers;

use Elastica\Result;
use Elastica\Document;
use Robbo\Presenter\Presenter;
use Illuminate\Database\Eloquent\Model;

/**
 * TransformerInterface
 *
 * A contract for transformer.
 *
 * @author Mohammad Emran Hasan <phpfour@gmail.com>
 */
interface TransformerInterface
{
    /**
     * Transform an Eloquent model into an Elastica document.
     *
     * @param Model $model
     * @param Document $document
     * @return Document
     */
    public function toDocument(Model $model, Document $document);

    /**
     * Transform an Elastica result into an Eloquent model.
     *
     * @param Result $result
     * @param Model $model
     * @return Model
     */
    public function toModel(Result $result, Model $model);

    /**
     * Transform an Elastica result into a presenter
     *
     * @param Result $result
     * @param Model $model
     * @return Presenter
     */
    public function toPresenter(Result $result, Model $model);
}
