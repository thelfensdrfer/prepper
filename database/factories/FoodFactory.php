<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

use App\Food;

$factory->define(Food::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'count' => $faker->numberBetween(1, 5),
        'weight' => $faker->numberBetween(0.5, 20) * 100,
        'expired_after' => $faker->dateTimeInInterval('-1 month', '+10 years'),
    ];
});
