<?php

use ArtemiyKudin\log\Models\Log;
use Faker\Generator as Faker;

$factory->define(Log::class, function (Faker $faker) {
    return [
        'message' => 1,
        'useragent' => $faker->text(20),
        'typeID' => 2,
        'isRead' => 0
    ];
});
