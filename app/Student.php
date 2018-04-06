<?php

namespace App;

use App\Http\Controllers\ConstantEnum;
use Illuminate\Database\Eloquent\Model;
use App\Http\DbInfoEnum;

/**
 * 클래스명:                       Student
 * 클래스 설명:                    학생 테이블과 연결하는 모델
 * 만든이:                         3-WDJ 1401213 이승민
 * 만든날:                         2018년 3월 19일
 */
class Student extends Model {
    // 01. 멤버 변수 설정
    public $incrementing    = false;
    public $timestamps      = false;

    // 02. 생성자 정의
    // 03. 멤버 메서드 정의
    /**
     * 함수명:                         comments
     * 함수 설명:                      코멘트 테이블과 학생 테이블의 연결 관계를 정의
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
    public function comments() {
        return $this->hasMany('App\Comment', 'std_id', 'id');
    }

    /**
     * 함수명:                         counsels
     * 함수 설명:                      상담 테이블과 학생 테이블의 연결 관계를 정의
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
    public function counsels() {
        return $this->hasMany('App\Counsel', 'std_id', 'id');
    }

    /**
     * 함수명:                         attendances
     * 함수 설명:                      학생 테이블과 출석 테이블의 연결 관계를 정의
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
    public function attendances() {
        return $this->hasMany('App\Attendance', 'std_id', 'id');
    }

    /**
     * 함수명:                         positions
     * 함수 설명:                      학생위치 테이블과 학생 테이블의 연결 관계를 정의
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
    public function positions() {
        return $this->hasMany('App\Position', 'std_id', 'id');
    }

    /**
     * 함수명:                         fingerprints
     * 함수 설명:                      학생 테이블과 지문 테이블의 연결 관계를 정의
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
    public function fingerprints() {
        return $this->hasMany('App\Fingerprint', 'std_id', 'id');
    }

    /**
     * 함수명:                         gainedScores
     * 함수 설명:                      학생 테이블과 취득점수 테이블의 연결 관계를 정의
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
    public function gainedScores() {
        return $this->hasMany('App\GainedScore', 'std_id', 'id');
    }

    /**
     * 함수명:                         CheckInLecture
     * 함수 설명:                      학생 테이블과 강의 중 출석 테이블의 연결 관계를 정의
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
    public function checkInLectures() {
        return $this->hasMany('App\CheckInLecture', 'std_id', 'id');
    }

    /**
     * 함수명:                         signUpLists
     * 함수 설명:                      학생 테이블과 수강목록 테이블의 연결 관계를 정의
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
    public function signUpLists() {
        return $this->hasMany('App\SignUpList', 'std_id', 'id');
    }

    /**
     * 함수명:                         group
     * 함수 설명:                      학생 테이블과 반 테이블의 연결 관계를 정의
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
    public function group() {
        return $this->belongsTo('App\Group', 'group', 'id');
    }

    /**
     * 함수명:                         alerts
     * 함수 설명:                      학생 테이블과 알림 테이블의 연결 관계를 정의
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
    public function alerts() {
        return $this->hasMany('App\Alert', 'std_id', 'id');
    }

    /**
     *  함수명:                            getLecturesInfo
     *  함수 설명:                         해당 학생이 해당 학기에 수강한 강의의 코드를 조회
     *  만든날:                            2018년 4월 4일
     *
     *  매개변수 목록
     *  @param $argYear:                   조회 연도
     *  @param $argTerm:                   조회 학기
     *
     *  지역변수 목록
     *  null
     *
     *  반환값
     *  @return                            mixed
     */
    public function getLecturesIdAtThisTerm($argYear, $argTerm) {
        return $this->signUpLists()
            // 수강 과목 테이블 조인 - 강의 코드와 과제별 성적 반영율을 획득
            ->join(DbInfoEnum::LECTURES['t_name'], DbInfoEnum::SIGN_UP_LISTS['t_name'].'.'.DbInfoEnum::SIGN_UP_LISTS['lec'], DbInfoEnum::LECTURES['t_name'].'.'.DbInfoEnum::LECTURES['id'])
            // 과목 테이블 조인 - 조회 연도와 학기를 제한하기 위해
            ->join(DbInfoEnum::SUBJECTS['t_name'], function($join) use ($argYear, $argTerm) {
                $join->on(DbInfoEnum::LECTURES['t_name'].'.'.DbInfoEnum::LECTURES['sub_id'], DbInfoEnum::SUBJECTS['t_name'].'.'.DbInfoEnum::SUBJECTS['id'])
                    ->where([
                        [DbInfoEnum::SUBJECTS['t_name'].'.'.DbInfoEnum::SUBJECTS['year'], $argYear],
                        [DbInfoEnum::SUBJECTS['t_name'].'.'.DbInfoEnum::SUBJECTS['term'], $argTerm]
                    ]);
            })
            // 조회목록 : 강의 아이디
            ->select(DbInfoEnum::LECTURES['t_name'].'.'.DbInfoEnum::LECTURES['id'])
            ->get()->all();
    }

    /**
     *  함수명:                            getDetailsOfLecture
     *  함수 설명:                         해당 강의에서 학생이 취득한 성적을 조회
     *  만든날:                            2018년 4월 4일
     *
     *  매개변수 목록
     *  @param $argLectureId:              조회하는 강의 번호
     *
     *  지역변수 목록
     *  null
     *
     *  반환값
     *  @return                            mixed
     */
    public function getDetailsOfLecture($argLectureId) {
        return $this->gainedScores()
            ->rightJoin(DbInfoEnum::SCORES['t_name'], function($join) use ($argLectureId) {
                $join->on(DbInfoEnum::SCORES['t_name'].'.'.DbInfoEnum::SCORES['id'], DbInfoEnum::GAINED_SCORES['t_name'].'.'.DbInfoEnum::GAINED_SCORES['type'])
                    ->where(DbInfoEnum::SCORES['t_name'].'.'.DbInfoEnum::SCORES['lecture'], $argLectureId);
            })->selectRaw(
                DbInfoEnum::SCORES['t_name'].'.'.DbInfoEnum::SCORES['reg_date'].",
                CASE ".DBInfoEnum::SCORES['t_name'].'.'.DbInfoEnum::SCORES['type']." 
                WHEN ".ConstantEnum::SCORE['midterm']." THEN '".__('lecture.midterm')."'
                WHEN ".ConstantEnum::SCORE['final']." THEN '".__('lecture.final')."'
                    WHEN ".ConstantEnum::SCORE['quiz']." THEN '".__('lecture.quiz')."'
                WHEN ".ConstantEnum::SCORE['task']." THEN '".__('lecture.task')."' 
                END AS '".DbInfoEnum::SCORES['type']."', 
                ".DBInfoEnum::SCORES['t_name'].'.'.DbInfoEnum::SCORES['content'].", 
                ".DBInfoEnum::GAINED_SCORES['t_name'].'.'.DbInfoEnum::GAINED_SCORES['score'].", 
                ".DBInfoEnum::SCORES['t_name'].'.'.DbInfoEnum::SCORES['prefect']
            )->orderBy(DbInfoEnum::SCORES['t_name'].'.'.DbInfoEnum::SCORES['reg_date'], 'desc');

        /*
         * Student::find(9885116)->gainedScores()
         * ->join('scores', function($join) {
         *      $join->on('scores.id', 'gained_scores.score_type')
         *          ->where('scores.lecture_id', 14);
         * })->selectRaw("
         *      scores.reg_date,
         *      CASE scores.type
         *          WHEN 1 THEN 'AAA'
         *          ELSE 'BBB' END AS 'TYPE',
         *      scores.content, gained_scores.score,
         *      scores.perfect_score
         * ")->orderBy('scores.reg_date', 'desc')
         * ->paginate(3)
         */
    }
}