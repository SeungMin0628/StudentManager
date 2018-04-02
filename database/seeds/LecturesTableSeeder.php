<?php

use Illuminate\Database\Seeder;
use App\Lecture;
use App\Subject;
use App\Professor;
use App\Http\DbInfoEnum;

/**
 * 클래스명:                       LecturesTableSeeder
 * 클래스 설명:                    강의 더미 데이터를 생성하는 시더
 * 만든이:                         3-WDJ 8조 春目指す 1401213 이승민
 * 만든날:                         2018년 4월 02일
 */
class LecturesTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        // 과목 목록 구하기
        $subjects = Subject::all();

        $subjects->each(function($subject) {
            // 교과목 교수 목록 구하기
            $professors = Professor::where([
                [DbInfoEnum::PROFESSORS['manager'], '<>', NULL],
                [DbInfoEnum::PROFESSORS['expire'], '<>', NULL]
            ])->get()->all();

            $loop_count = $subject->division_flag ? 2 : 1;
            for($iCount = 0; $iCount <= $loop_count; $iCount++) {
                shuffle($professors);
                $lecture = new Lecture();

                $lecture->subject_id        = $subject->id;
                $lecture->divided_class_id  = $subject->division_flag ? NULL : chr($iCount + 65);
                $lecture->professor         = $professors[0]->id;

                $lecture->save();
            }
        });
    }
}
