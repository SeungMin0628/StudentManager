<?php

namespace App;

use App\Http\DbInfoEnum;
use App\GainedScore;
use App\SignUpList;
use Illuminate\Database\Eloquent\Model;

/**
 * 클래스명:                       Score
 * 클래스 설명:                    점수 테이블과 연결하는 모델
 * 만든이:                         3-WDJ 1401213 이승민
 * 만든날:                         2018년 3월 19일
 */
class Score extends Model {
    // 01. 멤버 변수 설정
    public $timestamps  = false;

    // 02. 생성자 정의
    // 03. 멤버 메서드 정의

    // 테이블 간의 연결관계 정의
    /**
     * 함수명:                         lecture
     * 함수 설명:                      교과목 테이블과 점수 테이블의 연결 관계를 정의
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

    /**
     * 함수명:                         gainedScores
     * 함수 설명:                      취득점수 테이블과 점수 테이블의 연결 관계를 정의
     * 만든날:                         2018년 3월 19일
     *
     * 매개변수 목록
     * null
     *
     * 지역변수 목록
     * null
     *
     * 반환값
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gainedScore() {
        return $this->hasMany('App\GainedScore', 'score_type', 'id');
    }

    /**
     * 함수명:                         selectGainedScoreForStudent
     * 함수 설명:                      해당 학생이 해당 과목에서 취득한 점수 목록을 출력
     * 만든날:                         2018년 4월 05일
     *
     * 매개변수 목록
     * @param $lectureId:              과목 번호
     * @param $stdId:                  학번
     *
     * 지역변수 목록
     * null
     *
     * 반환값
     * @return                          mixed
     */

    // SELECT 구문
    public static function selectGainedScoreForStudent($lectureId, $stdId) {
        return Score::where(DbInfoEnum::SCORES['lecture'], $lectureId)
            ->leftJoin(DbInfoEnum::GAINED_SCORES['t_name'], function($join) use ($stdId) {
                 $join->on(DbInfoEnum::GAINED_SCORES['t_name'].'.'.DbInfoEnum::GAINED_SCORES['type'], DbInfoEnum::SCORES['t_name'].'.'.DbInfoEnum::SCORES['id'])
                     ->where(DbInfoEnum::GAINED_SCORES['t_name'].'.'.DbInfoEnum::GAINED_SCORES['std_id'], $stdId);
            })
            ->selectRaw(
                DbInfoEnum::SCORES['t_name'].".".DbInfoEnum::SCORES['type']." AS 'type',
                COUNT(".DbInfoEnum::SCORES['t_name'].".".DbInfoEnum::SCORES['id'].") AS 'count',  
                AVG(".DbInfoEnum::GAINED_SCORES['t_name'].".".DbInfoEnum::GAINED_SCORES['score'].") AS 'average',
                SUM(".DbInfoEnum::GAINED_SCORES['t_name'].".".DbInfoEnum::GAINED_SCORES['score'].") AS 'gained_score', 
                SUM(".DbInfoEnum::SCORES['t_name'].".".DbInfoEnum::SCORES['prefect'].") AS 'perfect_score'            
             ")
            ->groupBy(DbInfoEnum::SCORES['t_name'].".".DbInfoEnum::SCORES['type'])
            ->get()->all();
    }

    // INSERT 구문

    public function insertScoreList(Score $score, array $argStdList) {
        // 해당 성적 데이터가 저장되었으면 => 각 학생의 성적 등록
        if($score->save()) {
            // 각 학생의 성적 등록
            foreach ($argStdList as $stdId => $scoreValue) {
                $gainedScore = new GainedScore();

                $gainedScore->score_type = $score->id;
                $gainedScore->std_id = $stdId;
                $gainedScore->score = $scoreValue;

                $gainedScore->save();

                // 학업 성취도 갱신
                $signUpList = SignUpList::where([
                    [DbInfoEnum::SIGN_UP_LISTS['lec'], $score->lecture_id],
                    [DbInfoEnum::SIGN_UP_LISTS['s_id'], $stdId]
                ])->updateAchievement();
            }

            return true;
        } else {
            return false;
        }
    }
}
