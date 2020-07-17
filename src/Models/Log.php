<?php

namespace ArtemiyKudin\log\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $primaryKey = 'logID';
    protected $table = 'log';
    protected $guarded = ['_token'];

    public function user(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(config('artLog.models.user'), 'userID', 'userID');
    }

    public function profile(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(config('artLog.models.profile'), 'profileID', 'profileID');
    }
}
