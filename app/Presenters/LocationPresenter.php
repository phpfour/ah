<?php

namespace App\Presenters;

use Robbo\Presenter\Presenter;

class LocationPresenter extends Presenter
{
    protected $highlight;

    public function setHighlight($highlight)
    {
        $this->highlight = $highlight;
    }
}