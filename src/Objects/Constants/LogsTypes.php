<?php

namespace ArtemiyKudin\log\Objects\Constant;

use ArtemiyKudin\log\Objects\Interfaces\LogsTypesInterface;

class LogsTypes implements LogsTypesInterface
{
    private const TYPE_CLIENT_IMPORT = 1;
    private const TYPE_LOGIN = 2;
    private const TYPE_LOGOUT = 3;

    private $arrTypesTranslate = [
        self::TYPE_CLIENT_IMPORT => 'Импорт клиентов',
        self::TYPE_LOGIN => 'Вход сотрудника',
        self::TYPE_LOGOUT => 'Выход сотрудника'
    ];

    public function importType(): int
    {
        return self::TYPE_CLIENT_IMPORT;
    }

    public function loginType(): int
    {
        return self::TYPE_LOGIN;
    }

    public function logoutType(): int
    {
        return self::TYPE_LOGOUT;
    }

    public function typeName(int $id): string
    {
        return $this->arrTypesTranslate[$id];
    }

    public function typeArray(): array
    {
        return $this->arrTypesTranslate;
    }
}
