<?php

namespace ArtemiyKudin\log\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $primaryKey = 'logID';
    protected $table = 'log';
    protected $guarded = ['_token'];

    public const TYPE_CLIENT_IMPORT = 1;
    public const TYPE_LOGIN = 2;
    public const TYPE_LOGOUT = 3;

    public static $arrTypesTranslate = [
        self::TYPE_CLIENT_IMPORT => 'Импорт клиентов',
        self::TYPE_LOGIN => 'Вход сотрудника',
        self::TYPE_LOGOUT => 'Выход сотрудника'
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(User::class, 'userID', 'userID');
    }

    public function profile(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Profile::class, 'profileID', 'profileID');
    }
}
