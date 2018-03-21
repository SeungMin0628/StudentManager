<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * 클래스명:                       AccountSync
 * 클래스 설명:                    계정 연동 테이블과 연결하는 모델
 * 만든이:                         3-WDJ 1401213 이승민
 * 만든날:                         2018년 3월 19일
 */
class AccountSync extends Model {
    // 01. 멤버 변수 설정
    public $timestamps      = false;

    // 02. 생성자 정의
    // 03. 멤버 메서드 정의
    /**
     * 함수명:                         prime_professor
     * 함수 설명:                      교수 테이블과 계정 연동 테이블 현재 접속 계정 칼럼의 연결 관계를 정의
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
    public function prime_professor() {
        return $this->belongsTo('App\Professor', 'prime_account', 'id');
    }

    /**
     * 함수명:                         connected_professor
     * 함수 설명:                      교수 테이블과 현재 접속된 계정에 연동된 계정 칼럼의 연결 관계를 정의
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
    public function connected_professor() {
        return $this->belongsTo('App\Professor', 'connected', 'id');
    }
}
