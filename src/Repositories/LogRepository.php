<?php

namespace ArtemiyKudin\log\Repositories;

use ArtemiyKudin\log\Models\Log;

class LogRepository extends Repository
{
    public function __construct(Log $log)
    {
        parent::__construct();

        $this->model = $log;
    }
}
