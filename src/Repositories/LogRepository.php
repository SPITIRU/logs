<?php

namespace ArtemiyKudin\log\Repositories;

use ArtemiyKudin\log\Models\Log;

class LogRepository
{
    public function __construct(Log $log)
    {
        $this->model = $log;
    }
}
