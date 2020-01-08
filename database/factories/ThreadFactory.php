<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Thread;
use Faker\Generator as Faker;

$factory->define(Thread::class, function (Faker $faker) {
    return [
        'user_id' => function(){
            return factory('App\User')->create()->id;
        },
        // 'user_id' => $faker->numberBetween(1,30),
        'title' => $faker->sentence,
        'body' => $faker->paragraph,
    ];
});
