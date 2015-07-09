<?php

namespace App\Presenters;

use Robbo\Presenter\Presenter;

class JobPresenter extends Presenter
{
    protected $blurbLength = 200;
    protected $highlight;

    public function presentBlurb()
    {
        if (isset($this->highlight['description'])) {
            $string = $this->highlight['description'][0];
        } else {
            $string = substr($this->object->description, 0, $this->blurbLength);
        }

        $string = (strlen($string) === $this->blurbLength) ? $string .= '&hellip;' : $string;

        return $string;
    }

    public function presentTitle()
    {
        if (isset($this->highlight['title'])) {
            return $this->highlight['title'][0];
        } else {
            return $this->object->jobtitle;
        }
    }

    public function setHighlight($highlight)
    {
        $this->highlight = $highlight;
    }
}