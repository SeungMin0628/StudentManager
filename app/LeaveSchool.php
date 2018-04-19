<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * 클래스명:                       LeaveSchool
 * 클래스 설명:                    하교 테이블과 연결하는 모델
 * 만든이:                         3-WDJ 1401213 이승민
 * 만든날:                         2018년 3월 19일
 */
class LeaveSchool extends Model {
    // 01. 멤버 변수 설정
    public $timestamps  = false;

    // 02. 생성자 정의
    // 03. 멤버 메서드 정의

    // 테이블 관계도 설정
    /**
     * 함수명:                         attendance
     * 함수 설명:                      하교 테이블과 출석 테이블의 연결 관계를 정의
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
        return $this->hasOne('App\Attendance', 'leave_school', 'id');
    }

    /**
     * 함수명:                         classification
     * 함수 설명:                      하교 테이블과 출석 유형 테이블의 연결 관계를 정의
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

    // 클래스 메서드
    public static function insertLeaveSchool($argStdId) {
        // 01. 등교한 학생 정보 조회
        $student = Student::findOrFail($argStdId);

        // 02. 학생이 소속된 반의 등교 시간 조회
        // DB에 저장된 하교시각
        $leaveTimeValue  = $student->group()->get()[0]->home_time;
        // Carbon을 이용한 하교 제한시간 계산
        $limitTime = Carbon::createFromFormat('Y-m-d H:i:s', (today()->format('Y-m-d').' '.$leaveTimeValue));
        // 조퇴 판단 플래그
        $earlyFlag = $limitTime->gt(now());

        // 등교 데이터 생성
        $leaveSchool = new self();
        $leaveSchool->reg_time = now()->format('Y-m-d H:i:s');
        $leaveSchool->early_flag = $earlyFlag;
        $leaveSchool->classification = $earlyFlag ? 2 : 1;

        if($leaveSchool->save()) {
            return $leaveSchool->id;
        } else {
            return false;
        }
    }
}
