<?php

use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(App\Models\Page::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(5),
        'meta_title' => $faker->sentence(5),
        'meta_keyword' => $faker->sentence(5),
        'meta_description' => $faker->sentence(5),
        'excerpt' => $faker->sentence(20),
        'content' => $faker->text(),
        'slug' => Str::slug($faker->sentence(5), '-')
    ];
});
