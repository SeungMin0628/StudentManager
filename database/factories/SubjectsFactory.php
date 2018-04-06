<?php

use Faker\Generator as Faker;
use App\Professor;
use App\Subject;
use App\Http\DbInfoEnum;

$factory->define(Subject::class, function (Faker $faker) {
    // 지도교수 아이디 구하기
    $tutors     = Professor::where([
        [DbInfoEnum::PROFESSORS['manager'], NULL],
        [DbInfoEnum::PROFESSORS['expire'], NULL]
    ])->get()->all();
    shuffle($tutors);

    // 더미 과목명
    $subject_names = [
        'JAVA', 'ANDROID', 'PHP', 'NODE.JS', 'SQL', 'MYSQL', 'ORACLE', 'JAPANESE', 'RUBY', 'C-LANGUAGE',
        'KOREAN', 'SCIENCE', 'MATH', 'SPI', 'JLPT', 'ENGLISH', 'PHOTOSHOP', 'FLASH', 'COMPUTER', 'OBJECT-C',
        'SWIFT', 'IOS PROGRAMMING', 'DATABASE', 'OS PRACTICE'
    ];

    return [
        'year'          => 2018,
        'term'          => 1,
        'group_id'      => $tutors[0]->group()->get()[0]->id,
        'id'            => $faker->unique()->randomNumber(8),
        'name'          => array_random($subject_names),
        'division_flag' => random_int(1, 10) > 9 ? TRUE : FALSE,
    ];
});
