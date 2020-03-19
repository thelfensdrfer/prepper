<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Checklist;
use Faker\Generator as Faker;

$factory->define(Checklist::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'icon' => $faker->randomElement([
            'band-aid',
            'tools',
            'shovel',
            'campground',
            'fire',
            'backpack',
            'hiking',
            'map',
            'rv',
            'route',
            'toilet-paper'
        ]),
    ];
});
