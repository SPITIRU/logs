<?php

    use ArtemiyKudin\log\Models\Log;
    use Beauty\Modules\Common\Models\Profile;
    use Beauty\Modules\Common\Models\User;

    return [
        'column_names' => [
            'profiles_key' => 'profileID',
            'users_key' => 'userID',
            'logs_key' => 'userID',
        ],

        'middleware' => [],

        'models' => [
            'log' => Log::class,
            'user' => User::class,
            'profile' => Profile::class
        ],

        'prefix' => 'api/crm',

        'routes' => [
            'prefix' => 'logs',
            'url' => [
                'index' => '/',
                'filters' => '/filters'
            ],
        ],

        'table_names' => [
            'logs' => 'logs',
            'users' => 'users',
            'profiles' => 'profiles',
        ],

        'take_logs' => 15
    ];
