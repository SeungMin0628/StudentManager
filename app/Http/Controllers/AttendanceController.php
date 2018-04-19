<?php

namespace App\Http\Controllers;

use App\ComeSchool;
use App\Http\DbInfoEnum;
use Illuminate\Http\Request;
use App\Http\Controllers\ConstantEnum;
use Psy\Exception\ErrorException;
use App\Attendance;
use App\Student;
use App\Http\Controllers\ResponseObject;

/**
 * 클래스명:                       AttendanceController
 * @package                        App\Http\Controllers
 * 클래스 설명:                    출석 관련 기능에 대해 정의하는 클래스
 * 만든이:                         3-WDJ 8조 春目指す 1401213 이승민
 * 만든날:                         2018년 4월 01일
 *
 * 생성자 매개변수 목록
 *  null
 *
 * 멤버 메서드 목록
 *  getAttendanceRecords($argStdId, $argPeriod, $argDate)
 *              : 학번, 조회기간 설정, 조회 일자를 받아 해당 일자 동안의 해당 학생의 출석 데이터를 조회
 *
 */
class AttendanceController extends Controller {
    // 01. 멤버 변수 설정
    // 02. 생성자 정의
    // 03. 멤버 메서드 정의

    /**
     * 함수명:                         getAttendanceRecords
     * 함수 설명:                      학생이 로그인했을 때 가장 먼저 보는 메인 페이지를 출력
     * 만든날:                         2018년 4월 01일
     *
     * 매개변수 목록
     * @param $argStdId(integer)       조회 학생의 학번
     * @param $argPeriod(string)       조회기간 설정
     * @param $argDate(string)         조회일자
     *
     * 지역변수 목록
     * $date                           일자 데이터를 계산할 기준값
     * $nowDate                        조회기준 현재일자
     * $prevDate                       이전 조회일자
     * $nextDate                       다음 조회일자
     * $formatDay                      일자 출력 포맷
     * $formatMonth                    월 출력 포맷
     *
     *
     * 반환값
     * @return                         array
     *      => 'query_result'          조회 결과
     *      => 'now_date'              현재일자
     *      => 'prev_date'             이전 조회일자
     *      => 'next_date'             다음 조회일자
     *      => 'rate'                  출석율
     *
     * 예외
     * @throws ErrorException
     */
    public function getAttendanceRecords($argStdId, $argPeriod, $argDate) {
        // 01. 데이터 가져오기
        // 조회 날짜 획득
        $date = null;
        switch($argPeriod) {
            case 'weekly':
                $date = $this->getWeeklyValue($argDate)['this_week'];
                break;
            case 'monthly':
                $date = $this->getMonthlyValue($argDate)['this_month'];
                break;
        }

        // 학번 획득
        $std_id = $argStdId;

        // DB 조회
        $result = NULL;
        if ($argPeriod === ConstantEnum::PERIOD['weekly']) {
            // 조회단위가 주인 경우 -> 이번주의 출석 기록을 조회
            $result = Attendance::selectAttendanceRecords($std_id,
                $date->copy()->startOfWeek()->format('Y-m-d'),
                $date->copy()->endOfWeek()->format('Y-m-d'))
                ->get()->all()[0];
        } else if ($argPeriod === ConstantEnum::PERIOD['monthly']) {
            // 조회단위가 달인 경우 -> 이번달의 출석기록을 조회
            $result = Attendance::selectAttendanceRecords($std_id,
                $date->copy()->startOfMonth()->format('Y-m-d'),
                $date->copy()->endOfMonth()->format('Y-m-d'))
                ->get()->all()[0];
        }

        // 출석율 계산

        if(($total_ada = $result->{ConstantEnum::ATTENDANCE['ada']} + $result->{ConstantEnum::ATTENDANCE['absence']}) > 0) {
            $rate = ($result->{ConstantEnum::ATTENDANCE['ada']} / $total_ada) * 100;
            $result['rate'] = number_format($rate, 2);
        }

        return $result;
    }

    // 학생 등교
    // 응답 메시지 형식 : array { status: 상태, message: 메시지 }
    public function comeSchool($argStdId) {
        // 01. 학번 검증
        $student = Student::findOrFail($argStdId);

        // 현재 등교여부 검증 => 최근 등교 데이터가 등교 is not null and 하교 is null 일 경우 현재 등교 중
        $recent_attd = Attendance::selectRecentlyAttendanceRecords($student->id);

        if(!is_null($recent_attd)) {
            // 등교 일자가 오늘이라면 => 함수 종료
            if ($recent_attd->reg_date == today()->format('Y-m-d')) {
                return new ResponseObject(
                    "false",
                    "오늘 등교하셨습니다."
                );
            }

            // 등교 데이터가 null이 아닐 때
            if (!is_null($recent_attd->come_school)) {
                // 하교 데이터가 null일 때
                if (is_null($recent_attd->leave_school)) {
                    // => 지난 번에 등교하고 하교를 하지 않음 => 하교 하라는 메시지 출력
                    return new ResponseObject(
                        'false',
                        '하교를 하지 않으셨습니다. 하교를 먼저 해주세요.'
                    );
                }
            }
        }

        // 출석 데이터 생성
        if (Attendance::insertAttendance($student->id) === false) {
            return new ResponseObject(
                'false',
                '데이터 생성 실패'
            );
        }

        // 출석이 끝나면 => 성공 메시지 반환
        return new ResponseObject(
            'true',
            __('message.login_success', ['name' => $student->name])
        );
    }

    // 학생 하교
    public function leaveSchool($argStdId) {
        // 01. 학번 검증
        $student = Student::findOrFail($argStdId);

        // 하교 자격 조건 검증
        // 현재 등교여부 검증 => 최근 등교 데이터가 등교 is not null and 하교 is null 일 경우 현재 등교 중
        $recent_attd = Attendance::selectRecentlyAttendanceRecords($student->id);

        // 최근 등교 데이터의 하교 데이터가 null이 아닌 경우 => 등교한 적이 없다고 판단.
        // 최근 출석 기록의 등교와 하교 모두 null인 경우 -> 결석이므로 등교를 먼저
        if(!is_null($recent_attd->leave_school) ||
            (is_null($recent_attd->come_school) && is_null($recent_attd->leave_school))) {
            return new ResponseObject(
                "false",
                "최근 등교기록이 없습니다. 등교를 우선 해주세요."
            );
        }

        // 출석 데이터 생성
        if(Attendance::updateAttendanceAtLeaveSchool($student->id) === false) {
            return new ResponseObject(
                'false',
                '데이터 생성 실패'
            );
        }

        // 출석이 끝나면 => 성공 메시지 반환
        return new ResponseObject(
            'true',
            '고생하셨습니다.'
        );
    }
}
