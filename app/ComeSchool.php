<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * 클래스명:                       ComeSchool
 * 클래스 설명:                    등교 테이블과 연결하는 모델
 * 만든이:                         3-WDJ 1401213 이승민
 * 만든날:                         2018년 3월 19일
 */
class ComeSchool extends Model {
    // 01. 멤버 변수 설정
    public $timestamps  = false;

    // 02. 생성자 정의
    // 03. 멤버 메서드 정의

    // 테이블 관계도 생성
    /**
     * 함수명:                         classification
     * 함수 설명:                      등교 테이블과 출석 유형 테이블의 연결 관계를 정의
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
    public function classification() {
        return $this->belongsTo('App\Classification', 'classification', 'id');
    }

    /**
     * 함수명:                         attendance
     * 함수 설명:                      등교 테이블과 출석 테이블의 연결 관계를 정의
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
    public function attendance() {
        return $this->hasOne('App\Attendance', 'come_school', 'id');
    }

    // 멤버 메서드 정의

    // 클래스 메서드

    // 출석
    public static function insertComeSchool($argStdId) {
        // 01. 등교한 학생 정보 조회
        $student = Student::findOrFail($argStdId);

        // 02. 학생이 소속된 반의 등교 시간 조회
        // DB에 저장된 등교시각
        $comeTimeValue  = $student->group()->get()[0]->school_time;
        // Carbon을 이용한 등교 제한시간 계산
        $limitTime = Carbon::createFromFormat('Y-m-d H:i:s', (today()->format('Y-m-d').' '.$comeTimeValue));
        // 지각 판단 플래그
        $lateFlag = $limitTime->lt(now());

        // 등교 데이터 생성
        $comeSchool = new self();
        $comeSchool->reg_time = now()->format('Y-m-d H:i:s');
        $comeSchool->lateness_flag = $lateFlag;
        $comeSchool->classification = $lateFlag ? 2 : 1;

        if($comeSchool->save()) {
            return $comeSchool->id;
        } else {
            return false;
        }
    }
}
