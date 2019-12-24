<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Contact;
use Faker\Generator as Faker;

$factory->define(Contact::class, function (Faker $faker) {
    $i = rand(0, 2);
    $category = 'Физическое лицо';
    if ($i == 0) {
        $name = $faker->firstNameMale;
    } elseif ($i == 1) {
        $name = $faker->firstNameFemale;
    } else {
        $name = $faker->company;
        $category = 'Юридическое лицо';
    }
    return [
        'name' => $name,
        'description' => $faker->text,
        'category' => $category,
        'isPublic' => true,
    ];
});
