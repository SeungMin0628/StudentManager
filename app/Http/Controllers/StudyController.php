<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use App\Score;
use App\Http\DbInfoEnum;

/**
 * 클래스명:                       StudyController
 * @package                        App\Http\Controllers
 * 클래스 설명:                    학업에 관련된 기능에 대해 정의하는 클래스
 * 만든이:                         3-WDJ 8조 春目指す 1401213 이승민
 * 만든날:                         2018년 4월 03일
 *
 * 생성자 매개변수 목록
 *  null
 *
 * 멤버 메서드 목록
 *
 */
class StudyController extends Controller {
    // 01. 멤버 변수 정의

    // 02. 멤버 메서드 정의
    /**
     * 함수명:                         getStudyAchievement
     * 함수 설명:                      해당 학생의 과목별 학업성취도를 획득
     * 만든날:                         2018년 4월 04일
     *
     * 매개변수 목록
     * @param $argStdId:               학번
     * @param $argYear:                조회 연도
     * @param $argTerm:                조회 학기
     *
     * 지역변수 목록
     * null
     *
     * 반환값
     * @return                         array
     */
    public function getStudyAchievement($argStdId, $argYear, $argTerm) {
        // 변수 설정
        $student = new Student();
        $lectureList = $student->getLecturesInfo($argStdId, $argYear, $argTerm);


        // 수강 강의별 필요 정보 삽입
        $lectureDataSet = [];
        foreach($lectureList as $lecture) {
            $scores     = new Score();
            $scoreInfo  = $scores->selectGainedScoreForStudent($lecture->id, $argStdId);

            $scoreList          = array();      // 각 과목별 점수 데이터를 저장하기 위한 배열
            $achievementList    = array();      // 각 과목별 학업성취율 계산을 위한 배열
            foreach($scoreInfo as $value) {
                $reflection = 0;
                switch($value['type']) {
                    case ConstantEnum::SCORE['midterm']:
                        $reflection = $lecture[DbInfoEnum::LECTURES['mid_ref']];
                        break;
                    case ConstantEnum::SCORE['final']:
                        $reflection = $lecture[DbInfoEnum::LECTURES['fin_ref']];
                        break;
                    case ConstantEnum::SCORE['task']:
                        $reflection = $lecture[DbInfoEnum::LECTURES['tsk_ref']];
                        break;
                    case ConstantEnum::SCORE['quiz']:
                        $reflection = $lecture[DbInfoEnum::LECTURES['quz_ref']];
                        break;
                }

                // 성적별 점수 도출
                $achievement = ($value['gained_score'] / $value['perfect_score']) * $reflection;
                array_push($achievementList, $achievement);

                $scoreList[$value['type']] = [
                    'type'              => __('lecture.'.ConstantEnum::SCORE[$value['type']]),
                    'count'             => $value['count'],
                    'perfect_score'     => $value['perfect_score'],
                    'gained_score'      => $value['gained_score'],
                    'average'           => number_format($value['average'], 2),
                    'reflection'        => number_format($reflection * 100, 2),
                ];
            }

            // 필요 데이터 삽입
            $temp = [
                'title'          => $lecture[DbInfoEnum::SUBJECTS['name']],
                'score'          => $scoreList,
                'achievement'    => number_format(array_sum($achievementList) * 100, 2),
                'lecture_id'     => $lecture[DbInfoEnum::LECTURES['id']]
            ];

            array_push($lectureDataSet, $temp);
        }

        return $lectureDataSet;
    }
}
