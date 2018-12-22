<?php

use Faker\Generator as Faker;

$factory->define(App\Game::class, function (Faker $faker) {
    $variant_array = [
        'primary',
        'secondary',
        'warning',
        'alert',
        'default'
    ];
    return [
        'title' => $faker->words(random_int(1, 5), true),
        'description' => $faker->text(500),
        'variant' => array_random($variant_array),
        'logo_id' => 9
    ];
});
