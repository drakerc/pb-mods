<?php

use Faker\Generator as Faker;

$factory->define(App\Post::class, function (Faker $faker) {
    return [
        'title' => $faker->words(random_int(1, 10), true),
        'body' => $faker->text(1000),
        'post_category_id' => random_int(1,4),
    ];
});
