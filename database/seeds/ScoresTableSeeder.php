
<?php

use Illuminate\Database\Seeder;
use App\Lecture;
use App\Score;
use Illuminate\Support\Carbon;

/**
 * 클래스명:                       ScoresTableSeeder
 * 클래스 설명:                    성적 더미 데이터를 생성하는 시더
 * 만든이:                         3-WDJ 8조 春目指す 1401213 이승민
 * 만든날:                         2018년 4월 02일
 */
class ScoresTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        // 현재 개설 강의 조회
        $lectures = Lecture::all();

        // 강의별 더미 성적 생성
        $lectures->each(function($lecture) {
            // 성적 유형별 loop
            // 1 = 중간고사, 2 = 기말고사, 3 = 과제, 4 = 쪽지
            for($iCount = 1; $iCount <= 4; $iCount++) {
                // 유형이 과제 or 쪽지인 경우 무작위로 최대 4개 성적 정보 생성
                $jCount = 0;
                if($iCount > 2) {
                    $jCount += random_int(1, 3);
                }

                // 과목 정보 생성
                do {
                    $score = new Score();

                    // 과목 아이디 등록
                    $score->lecture_id = $lecture->id;
                    // 과제 유형 등록
                    $score->type = $iCount;
                    // 과제 상세설명 등록
                    switch ($iCount) {
                        case 1:
                            $score->content = '중간고사';
                            break;
                        case 2:
                            $score->content = '기말고사';
                            break;
                        case 3:
                            $score->content = '과제 상세 설명';
                            break;
                        case 4:
                            $score->content = '쪽지시험 상세 설명';
                            break;
                    }


                    // 등록일자 생성
                    $rand_month = random_int(3, 6);
                    $rand_day = random_int(1, 30);
                    $rand_date = Carbon::createFromDate(2018, $rand_month, $rand_day);
                    $score->reg_date = $rand_date->format('Y-m-d');

                    // 만점 등록
                    $score->perfect_score = random_int(16, 30) * 5;

                    $score->save();
                    $jCount--;
                } while($jCount > 0);
            }
        });
    }
}
