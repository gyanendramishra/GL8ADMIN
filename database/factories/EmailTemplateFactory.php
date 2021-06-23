<?php

use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(App\Models\EmailTemplate::class, function (Faker $faker) {
    return [
        'subject' => $faker->sentence(5),
        'content' => $faker->text(),
    ];
});
