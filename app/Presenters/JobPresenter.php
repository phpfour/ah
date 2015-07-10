<?php

namespace App\Presenters;

use Robbo\Presenter\Presenter;

class JobPresenter extends Presenter
{
    protected $blurbLength = 300;
    protected $highlight;

    public function presentId()
    {
        return $this->object->jobid;
    }

    public function presentCompany()
    {
        return $this->object->job_company ?: 'N/A';
    }

    public function presentPostDate()
    {
        return date('m.d.Y', strtotime($this->object->jobpostdate));
    }

    public function presentLocation()
    {
        return $this->object->city . ', ' . $this->object->province;
    }

    public function presentSourceUrl()
    {
        return $this->object->job_source_url;
    }

    public function presentMapUrl()
    {
        return "https://www.google.com/maps/?q={$this->object->job_ziplat},{$this->object->job_ziplon}";
    }




    public function presentBlurb()
    {
        if (isset($this->highlight['description'])) {
            $string = $this->highlight['description'][0];
        } else {
            $string = $this->removeExtraSpace($this->object->description);
            $string = substr($string, 0, $this->blurbLength);
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

    private function removeExtraSpace($string)
    {
        return trim(preg_replace('/[\s\t\n\r\s]+/', ' ', $string));
    }
}