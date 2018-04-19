<?php

use Faker\Generator as Faker;

$factory->define(App\Student::class, function (Faker $faker) {
    $std_id = $faker->unique()->randomNumber(7);
    $groups = App\Group::all();

    $group_id = array_random($groups->all())->id;

    return [
        "id"            => $std_id,
        "password"      => password_hash('password', PASSWORD_DEFAULT),
        "group"         => $group_id,
        "name"          => $faker->unique()->name(),
        "phone"         => "01000000000",
        "email"         => "null@null.null",
        "face_photo"    => ""
    ];
});
