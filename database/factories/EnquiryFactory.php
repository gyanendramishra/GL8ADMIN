<?php

use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(App\Models\Enquiry::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'phone' => $faker->tollFreePhoneNumber,
        'subject' => $faker->sentence(5),
        'message' => $faker->text(),
        'is_read' => false,
        'created_at' => Carbon::now()->addWeeks(rand(1, 52))
    ];
});
