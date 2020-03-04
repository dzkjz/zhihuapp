<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Topic;
use Faker\Generator as Faker;

$factory->define(Topic::class, function (Faker $faker) {
    return [
        //
        'name' => $faker->name,
        'content' => $faker->paragraph,
        'questions_count' => $faker->numberBetween(1, 10),
    ];
});
