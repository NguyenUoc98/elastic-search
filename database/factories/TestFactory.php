<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Test;
use Faker\Generator as Faker;

$factory->define(Test::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->text,
        'email' => $faker->unique()->safeEmail,
    ];
});
