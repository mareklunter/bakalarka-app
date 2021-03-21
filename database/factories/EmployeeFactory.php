<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Employee;
use Faker\Generator as Faker;

$factory->define(Employee::class, function (Faker $faker) {
    return [
        'user_id' => $faker->numberBetween(1,6),
        'firstName' => $faker->firstName,
        'lastName' => $faker->lastName,
        'work_position_id' => 1,
        'salary' => $faker->numberBetween(600,1200),
    ]; 
});
