<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ProductCategory;
use Faker\Generator as Faker;

$factory->define(ProductCategory::class, function (Faker $faker) {
    return [
        'user_id' => 1,
        'categoryName' => $faker->unique($reset = true)->randomElement(['alko','nealko','pizza','bezmäsité','cestoviny','polievky']),
    ];
});
