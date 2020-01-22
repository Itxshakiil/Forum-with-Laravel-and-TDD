<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Thread;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Thread::class, function (Faker $faker) {
    $title = $faker->sentence;
    return [
        'user_id' => function () {
            return factory('App\User')->create()->id;
        },
        'channel_id' => function () {
            return factory('App\Channel')->create()->id;
        },
        // 'user_id' => $faker->numberBetween(1,30),
        'visits' => 0,
        'title' => $title,
        'body' => $faker->paragraph,
    ];
});
