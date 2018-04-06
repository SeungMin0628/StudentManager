<?php

use Faker\Generator as Faker;

$factory->define(App\Professor::class, function (Faker $faker) {
    $gender = rand(0, 1) ? 'male' : 'female';

    $firstName  = $faker->firstName($gender);
    $lastName   = $faker->lastName;

    return [
        //
        'id'            => $firstName,
        'manager'       => null,
        'expire_date'   => null,
        'password'      => password_hash('password', PASSWORD_DEFAULT),
        'name'          => $firstName.' '.$lastName,
        'phone'         => "01012345678",
        'email'         => $faker->unique()->safeEmail,
        'office'        => "본관 100호",
        'face_photo'    => ""
    ];
});
