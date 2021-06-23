<?php

use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(App\Models\EmailHook::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence(5),
        'is_active' => true,
        'slug' => Str::slug($faker->sentence(5), '-')
    ];
});
