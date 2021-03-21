<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'user_id' => 1, 
        'name' => 'nazov jedla',
        'price' => $faker->randomFloat(2,3,8),
        'product_category_id' => '1',
        'description' => $faker->text(50),
    ];
}); 
