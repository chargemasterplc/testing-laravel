<?php

use Faker\Generator as Faker;

$factory->define(App\Task::class, function (Faker $faker) {
    return [
        'body' => $faker->sentence,
        'user_id' => function () {
            return factory(\App\User::class)->create()->id;
        },
        'completed' => false
    ];
});
