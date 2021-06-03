<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Employee;
use Faker\Generator as Faker;

$factory->define(Employee::class, function (Faker $faker) {
    return [
        'user_id'           => 1,
        'firstName'         => $faker->firstName,
        'lastName'          => $faker->lastName,
        'work_position_id'  => $faker->numberBetween(1,4),
        'phone'             => $faker->e164PhoneNumber,
        'employed_since'    => $faker->date($format = 'Y-m-d', $max = 'now'),
    ]; 
});
