<?php

namespace App\Presenters;

use Robbo\Presenter\Presenter;

/**
 * Location Presenter
 *
 * @author Mohammad Emran Hasan <phpfour@gmail.com>
 */
class LocationPresenter extends Presenter
{
    protected $highlight;

    public function setHighlight($highlight)
    {
        $this->highlight = $highlight;
    }
}