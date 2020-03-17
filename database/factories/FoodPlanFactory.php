<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

use App\FoodPlan;

$factory->define(FoodPlan::class, function (Faker $faker) {
    return [
        'optimal_stock' => $faker->numberBetween(20, 300) * 100,
    ];
});
