<?php

use Illuminate\Database\Seeder;
use App\Student;
use App\GainedScore;

/**
 * 클래스명:                       GainedScoresTableSeeder
 * 클래스 설명:                    학생 취득 성적 더미 데이터를 생성하는 시더
 * 만든이:                         3-WDJ 8조 春目指す 1401213 이승민
 * 만든날:                         2018년 4월 02일
 */
class GainedScoresTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        //
        $students = Student::all();

        $students->each(function($student) {
            // 해당 학생의 수강 목록 조회
            $signUpLists = $student->signUpLists()->get()->all();

            // 수강목록->수강 강의 정보 추출
            foreach($signUpLists as $signUpList) {
                $subject    = $signUpList->lecture()->get()[0];

                // 해당 강의에 생성된 성적 정보 추출
                $scores     = $subject->scores()->get()->all();
                // 개설 성적 추출
                foreach ($scores as $score) {
                    // 취득 성적 등록
                    $gainedScore = new GainedScore();

                    $gainedScore->score_type    = $score->id;
                    $gainedScore->std_id        = $student->id;
                    $p_s    = $score->perfect_score;
                    $gainedScore->score         = random_int(intval($p_s / 2), $p_s);

                    $gainedScore->save();
                }
            }
        });

        // 학생별 학업 성취도 갱신
        Student::all()->each(function ($student) {
           $student->signUpLists()->each(function ($signUpList) {
               $signUpList->updateAchievement();
           });
        });
    }
}
