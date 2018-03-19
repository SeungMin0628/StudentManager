<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * 클래스명:                       Professor
 * 클래스 설명:                    교수 테이블과 연결하는 모델
 * 만든이:                         3-WDJ 1401213 이승민
 * 만든날:                         2018년 3월 19일
 */
class Professor extends Model
{
    // 01. 멤버 변수 설정
    // 02. 생성자 정의
    // 03. 멤버 메서드 정의
    /**
     * 함수명:                         counsels
     * 함수 설명:                      상담 테이블과 교수 테이블의 연결 관계를 정의
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
     * 함수명:                         comments
     * 함수 설명:                      코멘트 테이블과 교수 테이블의 연결 관계를 정의
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
     * 함수명:                         alerts
     * 함수 설명:                      알림 테이블과 교수 테이블의 연결 관계를 정의
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

    /**
     * 함수명:                         group
     * 함수 설명:                      반 테이블과 교수 테이블의 연결 관계를 정의
     * 만든날:                         2018년 3월 19일
     *
     * 매개변수 목록
     * null
     *
     * 지역변수 목록
     * null
     *
     * 반환값
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function group() {
        return $this->hasOne('App\Group');
    }

    /**
     * 함수명:                         lecture
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
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function lecture() {
        return $this->hasOne('App\Lecture');
    }

    /**
     * 함수명:                         needCareAlerts
     * 함수 설명:                      관심학생 알림 테이블과 교수 테이블의 연결 관계를 정의
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
    public function needCareAlerts() {
        return $this->hasMany('App\NeedCareAlert');
    }

    /**
     * 함수명:                         managerProfessors
     * 함수 설명:                      지도교수가 교과목 교수들의 계정을 가지는 자기참조 관게를 정의
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
    public function managedProfessors() {
        return $this->hasMany('App\Professor');
    }

    /**
     * 함수명:                         manager
     * 함수 설명:                      교과목 교수의 계정이 지도교수에게 종속되는 자기참조 관계를 정의
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
    public function manager() {
        return $this->belongsTo('App\Professor');
    }

    /**
     * 함수명:                         accountSyncs
     * 함수 설명:                      교수 테이블과 계정 연동 테이블의 연결 관계를 정의
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
    public function accountSyncs() {
        return $this->hasMany('App\AccountSync');
    }
}
