<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * 클래스명:                       Student
 * 클래스 설명:                    학생 테이블과 연결하는 모델
 * 만든이:                         3-WDJ 1401213 이승민
 * 만든날:                         2018년 3월 19일
 */
class Student extends Model
{
    // 01. 멤버 변수 설정
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
        return $this->hasMany('App\Comment');
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
        return $this->hasMany('App\Counsel');
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
        return $this->hasMany('App\Attendance');
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
        return $this->hasMany('App\Position');
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
        return $this->hasMany('App\Fingerprint');
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
        return $this->hasMany('App\GainedScore');
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
    public function checkInLecture() {
        return $this->hasMany('App\CheckInLecture');
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
        return $this->hasMany('App\SignUpList');
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
        return $this->belongsTo('App\Group');
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
        return $this->hasMany('App\Alert');
    }
}