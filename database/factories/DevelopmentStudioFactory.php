<?php

use Faker\Generator as Faker;

$factory->define(App\DevelopmentStudio::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'email' => $faker->companyEmail,
        'address' => $faker->streetAddress,
        'description' => $faker->text(1024),
        'commercial' => false,
        'specialization' => 0,
        'website' => $faker->url
    ];
});
