<?php

use Faker\Generator as Faker;

$factory->define(App\Student::class, function (Faker $faker) {
    return [
        "id"            => $faker->unique()->randomNumber(7),
        "password"      => bcrypt('password'),
        "name"          => $faker->unique()->name(),
        "phone"         => "01000000000",
        "email"         => "null@null.null",
        "face_photo"    => null
    ];
});
