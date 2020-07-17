<?php

    return [
        'models' => [
            'log' => ArtemiyKudin\log\Models\Log::class,
        ],
        'tables' => [
            'users' => \Beauty\Modules\Common\Models\User::class,
            'profiles' => \Beauty\Modules\Common\Models\Profile::class
        ],
        'table_names' => [
            'logs' => 'logs',
        ],
    ];
