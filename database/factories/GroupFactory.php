<?php

use Faker\Generator as Faker;

$factory->define(App\Group::class, function (Faker $faker) {
    return [
        'name'          => "일본취업반"
    ];
});
