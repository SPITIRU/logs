<?php

namespace ArtemiyKudin\log;

class Logger
{
    protected $activity;

//    public function __construct()
//    {
//    }

    public function log()
    {
        dd($this->activity);
        $log = $this->activity;
        $log->save();

        return $log;
    }
}
