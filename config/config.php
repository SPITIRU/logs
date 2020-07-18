<?php

    return [
        'models' => [
            'log' => \ArtemiyKudin\log\Models\Log::class,
            'user' => \Beauty\Modules\Common\Models\User::class,
            'profile' => \Beauty\Modules\Common\Models\Profile::class
        ],
        'table_names' => [
            'logs' => 'logs',
            'users' => 'users',
            'profiles' => 'profiles',
        ],
    ];
