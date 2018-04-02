<?php

use Illuminate\Database\Seeder;
use App\Subject;

/**
 * 클래스명:                       SubjectsTableSeeder
 * 클래스 설명:                    과목 더미 데이터를 생성하는 시더
 * 만든이:                         3-WDJ 8조 春目指す 1401213 이승민
 * 만든날:                         2018년 4월 02일
 */
class SubjectsTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        //
        factory(Subject::class, 30)->create();
    }
}
