<?php

namespace App;

use Doctrine\DBAL\DBALException;
use Illuminate\Database\Eloquent\Model;
use App\Http\DbInfoEnum;

/**
 * 클래스명:                       Professor
 * 클래스 설명:                    교수 테이블과 연결하는 모델
 * 만든이:                         3-WDJ 1401213 이승민
 * 만든날:                         2018년 3월 19일
 */
class Professor extends Model {
    // 01. 멤버 변수 설정
    public $incrementing    = false;
    public $timestamps      = false;

    // 02. 생성자 정의
    // 03. 멤버 메서드 정의

    // 모델 연결관계 정의
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
        return $this->hasMany('App\Counsel', 'prof_id', 'id');
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
        return $this->hasMany('App\Comment', 'prof_id', 'id');
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
        return $this->hasMany('App\Alert', 'prof_id', 'id');
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
        return $this->hasOne('App\Group', 'tutor', 'id');
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
        return $this->hasOne('App\Lecture', 'professor', 'id');
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
        return $this->hasMany('App\NeedCareAlert', 'manager', 'id');
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
        return $this->hasMany('App\Professor', 'manager', 'id');
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
        return $this->belongsTo('App\Professor', 'manager', 'id');
    }

    /**
     * 함수명:                         primeAccount
     * 함수 설명:                      교수 테이블과 계정 연동 테이블의 주 계정 칼럼 간의 연결 관계를 정의
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
    public function primeAccount() {
        return $this->hasMany('App\AccountSync', 'prime_account', 'id');
    }

    /**
     * 함수명:                         connected
     * 함수 설명:                      교수 테이블과 계정 연동 테이블의 연동 계정 칼럼 간의 연결 관계를 정의
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
    public function connected() {
        return $this->hasMany('App\AccountSync', 'connected', 'id');
    }

    // 사용자 정의 - 클래스 함수
    /**
     * 함수명:                         getTutors
     * 함수 설명:                      지도교수 목록을 조회
     * 만든날:                         2018년 4월 06일
     *
     * 매개변수 목록
     * null
     *
     * 지역변수 목록
     * null
     *
     * 반환값
     * @return                         mixed
     */
    public static function getTutors() {
        return self::whereNull(DbInfoEnum::PROFESSORS['expire'])
            ->whereNull(DbInfoEnum::PROFESSORS['manager'])->get();
    }

    /**
     * 함수명:                         getProfessors
     * 함수 설명:                      교과목교수 목록을 조회
     * 만든날:                         2018년 4월 06일
     *
     * 매개변수 목록
     * null
     *
     * 지역변수 목록
     * null
     *
     * 반환값
     * @return                         mixed
     */
    public static function getProfessors() {
        return self::whereNotNull(DbInfoEnum::PROFESSORS['expire'])
            ->whereNotNull(DbInfoEnum::PROFESSORS['manager'])->get();
    }

    // 사용자 정의 - 멤버 메서드
    /**
     * 함수명:                         isExistMyGroup
     * 함수 설명:                      현재 사용자인 지도교수가 자신의 지도반을 가지고 있는지 조회
     * 만든날:                         2018년 4월 02일
     *
     * 매개변수 목록
     * @param $argProfId:              현재 접속중인 교수의 아이디
     *
     * 지역변수 목록
     * null
     *
     * 반환값
     * @return                         boolean
     */
    public function isExistMyGroup($argProfId) {
        return sizeof(
            Professor::find($argProfId)->group()->get()
        ) > 0;
    }

    public function getStudentsListOfMyLecture() {
        return $this->lecture()->get()[0]->signUpLists()
            ->join(DbInfoEnum::STUDENTS['t_name'],
                DbInfoEnum::STUDENTS['t_name'].'.'.DbInfoEnum::STUDENTS['id'],
                DbInfoEnum::SIGN_UP_LISTS['t_name'].'.'.DbInfoEnum::SIGN_UP_LISTS['s_id'])
            ->select(
                DbInfoEnum::STUDENTS['t_name'].'.'.DbInfoEnum::STUDENTS['id'],
                DbInfoEnum::STUDENTS['t_name'].'.'.DbInfoEnum::STUDENTS['name']
            )
            ->get();
    }
}
