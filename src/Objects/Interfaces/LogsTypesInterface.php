<?php

namespace ArtemiyKudin\log\Objects\Interfaces;

interface LogsTypesInterface
{
    public function importType(): int;
    public function loginType(): int;
    public function logoutType(): int;
}
