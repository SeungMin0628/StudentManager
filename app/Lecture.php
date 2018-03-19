<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * 클래스명:                       Lecture
 * 클래스 설명:                    강의 테이블과 연결하는 모델
 * 만든이:                         3-WDJ 1401213 이승민
 * 만든날:                         2018년 3월 19일
 */
class Lecture extends Model
{
    // 01. 멤버 변수 설정
    // 02. 생성자 정의
    // 03. 멤버 메서드 정의
    /**
     * 함수명:                         professor
     * 함수 설명:                      강의 테이블과 교수 테이블의 연결 관계를 정의
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
    public function professor() {
        return $this->belongsTo('App\Professor');
    }

    /**
     * 함수명:                         subject
     * 함수 설명:                      교과목 테이블과 강의 테이블의 연결 관계를 정의
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
    public function subject() {
        return $this->belongsTo('App\Subject');
    }

    /**
     * 함수명:                         signUpLists
     * 함수 설명:                      강의 테이블과 수강학생 목록 테이블의 연결 관계를 정의
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
     * 함수명:                         checkInLectures
     * 함수 설명:                      강의 테이블과 강의중 출석 테이블의 연결 관계를 정의
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
        return $this->hasMany('App\CheckInLecture');
    }

    /**
     * 함수명:                         scores
     * 함수 설명:                      강의 테이블과 점수 테이블의 연결 관계를 정의
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
    public function scores() {
        return $this->hasMany('App\Score');
    }

    /**
     * 함수명:                         timetables
     * 함수 설명:                      강의 테이블과 시간표 테이블의 연결 관계를 정의
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
    public function timetables() {
        return $this->hasMany('App\TimeTable');
    }
}
