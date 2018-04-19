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
    public  $incrementing   = false;
    public  $timestamps     = false;

    protected $primaryKey   = ['reg_date', 'std_id'];
    protected $fillable     = [
        'come_school', 'leave_school'
    ];

    // 02. 생성자 정의
    // 03. 멤버 메서드 정의

    // 테이블 관계도 정의
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

    /**
     * 함수명:                         selectAttendanceRecords
     * 함수 설명:                      출석 데이터 조회
     * 만든날:                         2018년 4월 3일
     *
     * 매개변수 목록
     * @param $argStdId:               학번
     * @param $startDate:              조회 시작일
     * @param $endDate:                조회 종료일
     *
     * 지역변수 목록
     * null
     *
     * 반환값
     * @return                         array
     */

    // 멤버 메서드
    // 고쳐야 됨
    public static function selectAttendanceRecords($argStdId, $startDate, $endDate) {
        // 01. 지역 변수 선언
        $dbInfoSelf     = DbInfoEnum::ATTENDANCES;
        $dbInfoCome     = DbInfoEnum::COME_SCHOOLS;
        $dbInfoLeave    = DbInfoEnum::LEAVE_SCHOOLS;
        $constList      = ConstantEnum::ATTENDANCE;

        return Attendance::where([
            ['std_id', $argStdId], ['reg_date', '>=', "{$startDate}"], ['reg_date', '<=', "{$endDate}"]
            ])->join('come_schools', 'attendances.come_school', 'come_schools.id')
            ->join('leave_schools', 'attendances.leave_school', 'leave_schools.id')
            ->selectRaw("
                (COUNT('attendances.id') - COUNT(CASE come_schools.lateness_flag WHEN TRUE THEN TRUE END) - COUNT(CASE attendances.absence_flag WHEN TRUE THEN TRUE END)) AS '{$constList['ada']}', 
                DATE_FORMAT(MAX(CASE WHEN {$dbInfoSelf['t_name']}.{$dbInfoSelf['absence']} IS NULL THEN {$dbInfoSelf['t_name']}.{$dbInfoSelf['reg_date']} END), '%Y-%m-%d') AS '{$constList['n_ada']}', 
                COUNT(CASE {$dbInfoCome['t_name']}.{$dbInfoCome['late']} WHEN TRUE THEN TRUE END) AS '{$constList['late']}', 
                DATE_FORMAT(MAX(CASE WHEN {$dbInfoCome['t_name']}.{$dbInfoCome['late']} IS TRUE THEN {$dbInfoSelf['t_name']}.{$dbInfoSelf['reg_date']} END), '%Y-%m-%d') AS '{$constList['n_late']}', 
                COUNT(CASE {$dbInfoSelf['t_name']}.{$dbInfoSelf['absence']} WHEN NOT NULL THEN TRUE END) AS '{$constList['absence']}', 
                DATE_FORMAT(MAX(CASE WHEN {$dbInfoSelf['t_name']}.{$dbInfoSelf['absence']} IS NOT NULL THEN {$dbInfoSelf['t_name']}.{$dbInfoSelf['reg_date']} END), '%Y-%m-%d') AS '{$constList['n_absence']}', 
                COUNT(CASE {$dbInfoLeave['t_name']}.{$dbInfoLeave['early']} WHEN TRUE THEN TRUE END) AS '{$constList['early']}', 
                DATE_FORMAT(MAX(CASE WHEN {$dbInfoLeave['t_name']}.{$dbInfoLeave['early']} IS TRUE THEN {$dbInfoSelf['t_name']}.{$dbInfoSelf['reg_date']} END), '%Y-%m-%d') AS '{$constList['n_early']}'
            ");
            /* selectRaw("
	            COUNT(CASE attendances.absence_flag WHEN NOT NULL THEN FALSE ELSE TRUE END) AS 'attendance',
                MAX(CASE WHEN attendances.absence_flag IS NOT NULL THEN FALSE ELSE attendances.reg_date END) AS 'nearest_attendance',
                COUNT(CASE come_schools.lateness_flag WHEN TRUE THEN TRUE END) AS 'late',
	            MAX(CASE WHEN come_schools.lateness_flag IS TRUE THEN attendances.reg_date END) AS 'nearest_late',
                COUNT(CASE attendances.absence_flag WHEN NOT NULL THEN TRUE END) AS 'absence',
                MAX(CASE WHEN attendances.absence_flag IS NOT NULL THEN attendances.reg_date END) AS 'nearest_absence',
                COUNT(CASE leave_schools.early_flag WHEN TRUE THEN TRUE END) AS 'early',
                MAX(CASE WHEN leave_schools.early_flag IS TRUE THEN attendances.reg_date END) AS 'nearest_early'
            ")*/
    }

    // 클래스 메서드
    public static function selectRecentlyAttendanceRecords($argStdId) {
        // 01. 학생 조회
        $student = Student::findOrFail($argStdId);

        $data = self::where('std_id', $student->id);

        if(sizeof($data->get()->all()) <= 0) {
            return null;
        } else {
            return $data->orderBy('reg_date', 'desc')->limit(1)->get()->all()[0];
        }

    }

    // 출석 데이터 생성
    public static function insertAttendance($argStdId) {
        // 학생 데이터 조회
        $student    = Student::findOrFail($argStdId);
        $comeSchool = ComeSchool::insertComeSchool($student->id);

        // 데이터 생성
        $attendance = new self();

        $attendance->reg_date = today()->format('Y-m-d');
        $attendance->std_id = $student->id;
        $attendance->come_school = $comeSchool;

        if($attendance->save()) {
            return $attendance->id;
        } else {
            return false;
        }
    }

    // 하교 시 출석 데이터 업데이트
    public static function updateAttendanceAtLeaveSchool($argStdId) {
        // 학생 데이터 조회
        $student = Student::findOrFail($argStdId);
        $leaveSchool = LeaveSchool::insertLeaveSchool($student->id);

        // 데이터 검색
        $attendance = self::where([['std_id', $student->id], ['leave_school', NULL]])
            ->orderBy('reg_date', 'desc')->limit(1);

        //$attendance->leave_school = $leaveSchool;

        if($attendance->update(['leave_school' => $leaveSchool])) {
            return true;
        } else {
            return false;
        }
    }
}
