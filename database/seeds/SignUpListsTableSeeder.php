<?php

use Illuminate\Database\Seeder;
use App\Student;
use App\SignUpList;
use App\Group;
use App\Subject;

/**
 * 클래스명:                       SignUpListsTableSeeder
 * 클래스 설명:                    강의 더미 데이터를 생성하는 시더
 * 만든이:                         3-WDJ 8조 春目指す 1401213 이승민
 * 만든날:                         2018년 4월 02일
 */
class SignUpListsTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        // 학생 목록 구하기
        $students = Student::all();

        $students->each(function($student) {
            // 학생이 소속된 반에 개설된 과목 목록 구하기
            $group = $student->group()->get()[0];
            $subjects = $group->subjects()->get()->all();

            // 각 과목별로 개설된 강좌를 조회
            foreach($subjects as $subject) {
                $lectures = $subject->lectures()->get()->all();

                // 분반이 존재하는 경우 분반 중 무작위로 하나 선택
                if(sizeof($lectures) > 1) {
                    shuffle($lectures);
                }
                $lecture = $lectures[0];

                $signUpList = new SignUpList();

                $signUpList->lecture_id = $lecture->id;
                $signUpList->std_id     = $student->id;

                $signUpList->save();
            }
        });
    }
}
