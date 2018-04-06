<?php

use Illuminate\Database\Seeder;
use App\Lecture;
use App\Subject;
use App\Professor;

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
        $subjects = Subject::all()->all();

        // 교과목교수 구하기
        $professors = Professor::getProfessors()->all();

        foreach($subjects as $subject) {
            // 현재 강의가 개설된 반의 교과목 교수 목록 구하기
            //    => 교과목교수의 관리자 ID가 해당 과목이 소속된 반의 지도교수 ID와 같을 시
            $filteredProfessors = array_filter($professors, function ($value) use ($subject) {
                return $value->manager == $subject->group()->get()[0]->tutor;
            });

            $loop_count = $subject->division_flag ? 2 : 1;
            for ($iCount = 0; $iCount < $loop_count; $iCount++) {
                $lecture = new Lecture();

                $lecture->subject_id = $subject->id;
                $lecture->divided_class_id = $subject->division_flag ? chr($iCount + 65) : NULL;
                $lecture->professor = $professors[array_keys($filteredProfessors)[0]]->id;
                array_splice($professors, array_keys($filteredProfessors)[0], 1);

                $lecture->save();
            }
        };
    }
}
