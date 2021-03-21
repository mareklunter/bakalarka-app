<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\WorkPosition;
use Faker\Generator as Faker;

$factory->define(WorkPosition::class, function (Faker $faker) {
    return [
        'user_id' => 1,
        'positionName' => $faker->unique($reset = true)->randomElement(['kuchár','food runner','vedúci kuchár','manažér','busser']),
    ];
});
