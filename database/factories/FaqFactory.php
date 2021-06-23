<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Faq::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(5),
        'description' => $faker->text(),
        'is_active' => true,
    ];
});
