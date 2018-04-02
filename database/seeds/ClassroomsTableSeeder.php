<?php

use Illuminate\Database\Seeder;
use App\Classroom;

/**
 * 클래스명:                       ClassroomsTableSeeder
 * 클래스 설명:                    강의실 더미 데이터를 생성하는 시더
 * 만든이:                         3-WDJ 8조 春目指す 1401213 이승민
 * 만든날:                         2018년 4월 02일
 */
class ClassroomsTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $names = [
            "본관 200호", "본관 201호", "본관 210호", "본관 211호", "본관 312호",
            "정보관 103호", "정보관 508호", "정보관 513호"
        ];

        foreach($names as $name) {
            $classroom = new Classroom();
            $classroom->name = $name;
            $classroom->save();
        }
    }
}
