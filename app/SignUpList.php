<?php

namespace App;

use App\Score;
use App\Lecture;
use App\Http\DbInfoEnum;
use App\Http\Controllers\ConstantEnum;
use Illuminate\Database\Eloquent\Model;

/**
 * 클래스명:                       SignUpList
 * 클래스 설명:                    학생 수강목록 테이블과 연결하는 모델
 * 만든이:                         3-WDJ 1401213 이승민
 * 만든날:                         2018년 3월 19일
 */
class SignUpList extends Model {
    // 01. 멤버 변수 설정
    public $timestamps  = false;

    // 02. 생성자 정의
    // 03. 멤버 메서드 정의

    // 테이블 관계 설정
    /**
     * 함수명:                         student
     * 함수 설명:                      학생 테이블과 수강학생 목록 테이블의 연결 관계를 정의
     * 만든날:                         2018년 3월 19일
     *
     * 매개변수 목록
     * null
     *
     * 지역변수 목록
     * null
     *
     * 반환값
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function student() {
        return $this->belongsTo('App\Student', 'std_id', 'lecture_id');
    }

    /**
     * 함수명:                         lecture
     * 함수 설명:                      학생 수강목록 테이블과 강의 테이블의 연결 관계를 정의
     * 만든날:                         2018년 3월 19일
     *
     * 매개변수 목록
     * null
     *
     * 지역변수 목록
     * null
     *
     * 반환값
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lecture() {
        return $this->belongsTo('App\Lecture', 'lecture_id', 'id');
    }


    // SELECT 구문

    // 클래스 함수
    public static function selectSignUpFlag($lectureId, $stdId) {
        $select = self::where([
            [DbInfoEnum::SIGN_UP_LISTS['lec'], $lectureId],
            [DbInfoEnum::SIGN_UP_LISTS['s_id'], $stdId]
        ])->get()->all();

        if(sizeof($select) > 0) {
            return $select[0];
        } else {
            return false;
        }
    }

    /**
     * 함수명:                         updateAchievement
     * 함수 설명:                      해당 학생의 학업 성취도를 갱신
     * 만든날:                         2018년 4월 10일
     *
     * 매개변수 목록
     * null
     *
     * 지역변수 목록
     * null
     *
     * 반환값
     * @return                         boolean
     */

    // UPDATE 구문
    public function updateAchievement() {
        // 01. 변수 설정
        $lectureId  = $this->lecture_id;
        $stdId      = $this->std_id;

        // 02. 해당 학생이 취득한 성적 데이터 구하기
        $score_data = Score::selectGainedScoreForStudent($lectureId, $stdId);

        // 03. 과목 정보 획득
        $lecture = Lecture::find($lectureId);

        // 04. 반영비에 따른 학업 성취도 계산
        $reflection = 0;
        $achievementList = array();
        foreach($score_data as $value) {
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

            // 성적별 점수 도출
            $achievement = ($value['gained_score'] / $value['perfect_score']) * $reflection;
            array_push($achievementList, $achievement);
        }

        // 학업 성취도 저장
        $this->achievement = array_sum($achievementList);
        if($this->save()) {
            return true;
        } else {
            return false;
        }
    }
}
