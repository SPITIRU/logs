<?php

namespace ArtemiyKudin\log\Models;

use ArtemiyKudin\log\Traits\HasLogs;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasLogs;

    protected $primaryKey = 'logID';
    protected $table = 'logs';
    protected $guarded = ['_token'];

    public function saveLog(int $userID, int $profileID, int $typeID, int $message): void
    {
        $model = new self();
        $model->userID = $userID;
        $model->profileID = $profileID;
        $model->typeID = $typeID;
        $model->message = $message;
        $model->useragent = request()->userAgent();
        $model->ip = request()->ip();
        $model->isRead = 0;
        $model->save();
    }
}
