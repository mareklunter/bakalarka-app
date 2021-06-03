<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Order;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {
    return [
        'user_id'   => 1,
        'price'     => $faker->randomFloat($nbMaxDecimals = 2, $min = 1, $max = 7),
        'paid'      => 1,
        'table_id'  => NULL,
    ];
});
