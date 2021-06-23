<?php

use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(App\Models\EmailLayout::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence(5),
        'content' => $faker->text(),
        'is_active' => true,
        'slug' => Str::slug($faker->sentence(5), '-')
    ];
});
