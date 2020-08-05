<?php

namespace ArtemiyKudin\log\Traits;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait HasLogs
{
    /**
     * A model may have multiple logs.
     */
    public function log(): HasMany
    {
        return $this->hasMany(
            config('artLog.models.log'),
            config('artLog.column_names.users_key'),
            config('artLog.column_names.users_key')
        );
    }

    /**
     * A model may have one user.
     */
    public function user(): HasOne
    {
        return $this->hasOne(
            config('artLog.models.user'),
            config('artLog.column_names.users_key'),
            config('artLog.column_names.users_key')
        );
    }

    /**
     * A model may have one profile.
     */
    public function profile(): HasOne
    {
        return $this->hasOne(
            config('artLog.models.profile'),
            config('artLog.column_names.profiles_key'),
            config('artLog.column_names.profiles_key')
        );
    }
}
