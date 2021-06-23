<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Enquiry::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'phone' => $faker->tollFreePhoneNumber,
        'subject' => $faker->sentence(5),
        'message' => $faker->text(),
    ];
});
