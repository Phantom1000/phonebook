<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Location;
use Faker\Generator as Faker;

$factory->define(Location::class, function (Faker $faker) {
    return [
        'country' => 'Россия',
        'town' => $faker->city,
        'address' => $faker->streetAddress
    ];
});
