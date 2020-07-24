<?php

    use ArtemiyKudin\log\Models\Log;
    use Beauty\Modules\Common\Models\Profile;
    use Beauty\Modules\Common\Models\User;

    return [
        'foreign' => [
            'profiles' => [
                'id' => 'profileID',
                'references' => 'profileID',
                'name' => 'profiles'
            ],
            'users' => [
                'id' => 'userID',
                'references' => 'userID',
                'name' => 'users'
            ]
        ],
        'models' => [
            'log' => Log::class,
            'user' => User::class,
            'profile' => Profile::class
        ],
        'table_names' => [
            'logs' => 'logs',
            'users' => 'users',
            'profiles' => 'profiles',
        ],
    ];
