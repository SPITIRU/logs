<?php

namespace ArtemiyKudin\log\Objects\Interfaces;

interface LogsMessagesInterface
{
    public function clientLoginLog(): int;
    public function clientImportLog(): int;

    public function messageName(int $id): ?string ;
    public function messageArray(): array ;
}
