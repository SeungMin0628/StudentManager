<?php

namespace App\Http\Controllers;

use App\Exceptions\NotAccessibleException;
use App\Lecture;
use App\SignUpList;
use Illuminate\Http\Request;
use App\Student;
use App\Score;
use App\Http\DbInfoEnum;
use Psy\Exception\ErrorException;

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
     * 함수 설명:                      해당 학생이 해당 학기에 수강한 모든 과목별 학업성취도를 획득
     * 만든날:                         2018년 4월 04일
     *
     * 매개변수 목록
     * @param $argStdId:               학번
     * @param $argYear:                조회 연도
     * @param $argTerm:                조회 학기
     *
     * 지역변수 목록
     * $student:                       학생 테이블 접근용 모델
     * $lectureList:                   학생이 수강한 과목 정보
     * $lectureDataSet:                각 과목별 학업성취 데이터
     *
     * 반환값
     * @return                         array
     */
    public function getStudyAchievementList($argStdId, $argYear, $argTerm) {
        // 변수 설정
        $student = Student::find($argStdId);
        $lectureList = $student->getLecturesIdAtThisTerm($argYear, $argTerm);


        // 수강 강의별 필요 정보 삽입
        $lectureDataSet = [];
        foreach($lectureList as $lecture) {
            array_push($lectureDataSet, $this->getStudyAchievement($lecture->id, $argStdId));
        }

        return $lectureDataSet;
    }

    public function getStudyAchievement($lectureId, $stdId) {
        $lecture        = Lecture::find($lectureId);

        // 존재하지 않는 강의에 접근하려는 경우 -> 예외 발생
        if(is_null($lecture)) {
            throw new ErrorException();
        }

        $subject        = $lecture->subject()->get()[0];
        $scoreInfo      = Score::selectGainedScoreForStudent($lectureId, $stdId);

        // 조회한 과목이 해당 학생이 수강하는 과목이 아닌 경우
        if(!($signUp = SignUpList::selectSignUpFlag($lectureId, $stdId))) {
            //throw new NotAccessibleException(__('exception.not_sign_upped_lecture'));
        }

        $scoreList          = array();      // 각 과목별 점수 데이터를 저장하기 위한 배열
        foreach($scoreInfo as $value) {
            $reflection = null;
            switch($value['type']) {
                case ConstantEnum::SCORE['midterm']:
                    $reflection = $lecture->{DbInfoEnum::LECTURES['mid_ref']};
                    break;
                case ConstantEnum::SCORE['final']:
                    $reflection = $lecture->{DbInfoEnum::LECTURES['fin_ref']};
                    break;
                case ConstantEnum::SCORE['task']:
                    $reflection = $lecture->{DbInfoEnum::LECTURES['tsk_ref']};
                    break;
                case ConstantEnum::SCORE['quiz']:
                    $reflection = $lecture->{DbInfoEnum::LECTURES['quz_ref']};
                    break;
            }

            $scoreList[$value['type']] = [
                'type'              => __('lecture.'.ConstantEnum::SCORE[$value['type']]),
                'count'             => $value['count'],
                'perfect_score'     => $value['perfect_score'],
                'gained_score'      => $value['gained_score'],
                'average'           => number_format($value['average'], 2),
                'reflection'        => number_format($reflection * 100, 0),
            ];
        }

        // 필요 데이터 삽입
        return [
            'title'          => $subject->{DbInfoEnum::SUBJECTS['name']},
            'score'          => $scoreList,
            'achievement'    => number_format($signUp->achievement * 100, 2),
            'gained_score'   => Student::find($stdId)->getDetailsOfLecture($lectureId)->get()->all(),
            'prof_info'      => $lecture->professor()
                                ->select(DbInfoEnum::PROFESSORS['name'], DbInfoEnum::PROFESSORS['f_p'])
                                ->get()[0]
        ];
    }
}
