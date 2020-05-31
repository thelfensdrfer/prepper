<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ChecklistItem;
use Faker\Generator as Faker;

$factory->define(ChecklistItem::class, function (Faker $faker) {
    return [
        'name' => $faker->words(2, true),
        'count' => $faker->numberBetween(0, 3),
        'target_count' => $faker->numberBetween(1, 4),
    ];
});
