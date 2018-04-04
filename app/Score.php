<?php

namespace App;

use App\Http\DbInfoEnum;
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

    public function selectGainedScoreForStudent($lectureId, $stdId) {
        return Score::where(DbInfoEnum::SCORES['lecture'], $lectureId)
            ->join(DbInfoEnum::GAINED_SCORES['t_name'], function($join) use ($stdId) {
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
}
