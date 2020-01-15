<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Notifications\ThreadWasUpdated;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use Illuminate\Notifications\DatabaseNotification;

$factory->define(DatabaseNotification::class, function (Faker $faker) {
    return [
    'id' => Str::uuid()->toString(),
    'type' => 'App\Notifications\ThreadWasUpdated',
    'notifiable_id' => function() {
        return auth()->id() ?: factory(User::class)->create()->id;
    },
    'notifiable_type' => 'App\User',
    'data'=> ['foo' => 'bar']
    ];
});
