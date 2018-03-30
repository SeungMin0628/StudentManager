<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\DbInfoEnum;
use App\Http\Controllers\ConstantEnum;

/**
 * 클래스명:                       Attendance
 * 클래스 설명:                    출석 연동 테이블과 연결하는 모델
 * 만든이:                         3-WDJ 1401213 이승민
 * 만든날:                         2018년 3월 19일
 */
class Attendance extends Model {
    // 01. 멤버 변수 설정
    public  $timestamps     = false;

    // 02. 생성자 정의
    // 03. 멤버 메서드 정의
    /**
     * 함수명:                         student
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function student() {
        return $this->belongsTo('App\Student', 'std_id', 'id');
    }

    /**
     * 함수명:                         comeSchool
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function comeSchool() {
        return $this->belongsTo('App\ComeSchool', 'come_school', 'id');
    }

    /**
     * 함수명:                         leaveSchool
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function leaveSchool() {
        return $this->belongsTo('App\LeaveSchool', 'leave_school', 'id');
    }

    public function selectAttendanceRecords($argStdId) {
        // 01. 지역 변수 선언
        $dbInfoSelf     = DbInfoEnum::ATTENDANCES;
        $dbInfoCome     = DbInfoEnum::COME_SCHOOLS;
        $dbInfoLeave    = DbInfoEnum::LEAVE_SCHOOLS;
        $constList      = ConstantEnum::ATTENDANCE;

        return Attendance::
            where([
                [DbInfoEnum::ATTENDANCES['std_id'], $argStdId],
                [DbInfoEnum::ATTENDANCES['reg_date'], '>=', '2018-03-23'],
                [DbInfoEnum::ATTENDANCES['reg_date'], '<=', '2018-03-30']
            ])
            // where([['std_id', $std_id], ['reg_date', '>=', $start_date], ['reg_date', '<=', $end_date]])
            ->join(
                DbInfoEnum::COME_SCHOOLS['t_name'],
                DbInfoEnum::ATTENDANCES['t_name'].'.'.DbInfoEnum::ATTENDANCES['come'],
                DbInfoEnum::COME_SCHOOLS['t_name'].'.'.DbInfoEnum::COME_SCHOOLS['id']
            )
            // join('come_schools', 'attendances.come_school', 'come_schools.id')
            ->join(
                DbInfoEnum::LEAVE_SCHOOLS['t_name'],
                DbInfoEnum::ATTENDANCES['t_name'].'.'.DbInfoEnum::ATTENDANCES['leave'],
                DbInfoEnum::LEAVE_SCHOOLS['t_name'].'.'.DbInfoEnum::LEAVE_SCHOOLS['id']
            )
            // join('leave_schools', 'attendances.leave_school', 'leave_schools.id')
            ->selectRaw("
                COUNT(CASE {$dbInfoSelf['t_name']}.{$dbInfoSelf['absence']} WHEN NOT NULL THEN FALSE ELSE TRUE END) AS '{$constList['ada']}', 
                (SELECT MAX({$dbInfoSelf['reg_date']}) FROM {$dbInfoSelf['t_name']} WHERE {$dbInfoSelf['absence']} IS NULL) AS '{$constList['n_ada']}', 
                COUNT(CASE {$dbInfoCome['t_name']}.{$dbInfoCome['late']} WHEN TRUE THEN TRUE END) AS '{$constList['late']}', 
                (SELECT DATE_FORMAT(MAX({$dbInfoCome['reg_time']}), '%Y-%m-%d') FROM {$dbInfoCome['t_name']} WHERE {$dbInfoCome['late']} = TRUE) AS '{$constList['n_late']}', 
                COUNT(CASE {$dbInfoSelf['t_name']}.{$dbInfoSelf['absence']} WHEN NOT NULL THEN TRUE END) AS '{$constList['absence']}', 
                (SELECT MAX({$dbInfoSelf['reg_date']}) FROM {$dbInfoSelf['t_name']} WHERE {$dbInfoSelf['absence']} = TRUE) AS '{$constList['n_absence']}', 
                COUNT(CASE {$dbInfoLeave['t_name']}.{$dbInfoLeave['early']} WHEN TRUE THEN TRUE END) AS '{$constList['early']}', 
                (SELECT DATE_FORMAT(MAX({$dbInfoLeave['reg_time']}), '%Y-%m-%d') FROM {$dbInfoLeave['t_name']} WHERE {$dbInfoLeave['early']} = TRUE) AS '{$constList['n_early']}'
            ")
            /* selectRaw("
            COUNT(CASE attendances.absence_flag WHEN NOT NULL THEN FALSE ELSE TRUE END) AS 'attendance', 
            (SELECT MAX(reg_date) FROM attendances WHERE absence_flag IS NULL) AS 'nearest_attendance',
            COUNT(CASE come_schools.lateness_flag WHEN TRUE THEN TRUE END) AS 'late', 
            (SELECT DATE_FORMAT(MAX(reg_time), '%Y-%m-%d') FROM come_schools WHERE lateness_flag = TRUE) AS 'nearest_late',
            COUNT(CASE attendances.absence_flag WHEN NOT NULL THEN TRUE END) AS 'absence', 
            (SELECT MAX(reg_date) FROM attendances WHERE absence_flag = TRUE) AS 'nearest_absence', 
            COUNT(CASE leave_schools.early_flag WHEN TRUE THEN TRUE END) AS 'early',
            (SELECT  DATE_FORMAT(MAX(reg_time), '%Y-%m-%d') FROM leave_schools WHERE early_flag = TRUE) AS 'nearest_early'")*/
            ->get()[0];
    }
}
