<?php

namespace App\Http\Controllers;

use App\Http\DbInfoEnum;
use Illuminate\Http\Request;
use App\Http\Controllers\ConstantEnum;
use Psy\Exception\ErrorException;
use App\Attendance;

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
        $date           = null;
        $nowDate        = null;
        $prevDate       = null;
        $nextDate       = null;
        $formatDay      = "Y-m-d";
        $formatMonth    = "Y-m";
        // 설정 조회기간에 따른 날짜 데이터 획득
        if(is_null($argDate)) {
            switch($argPeriod) {
                case ConstantEnum::PERIOD['weekly']:
                    $argDate = today()->format('Y-m-').today()->weekOfMonth;
                    break;
                case ConstantEnum::PERIOD['monthly']:
                    $argDate = today()->format('Y-m');
                    break;
            }
        }

        if($argPeriod === ConstantEnum::PERIOD['weekly']) {
            $date = $this->getWeeklyValue($argDate);
        } else if($argPeriod === ConstantEnum::PERIOD['monthly']) {
            $date = $this->getMonthlyValue($argDate);
        }

        // 각 기간에 대한 문자열 추출
        switch ($argPeriod) {
            // 주 단위
            case ConstantEnum::PERIOD['weekly'];
                $nowDate    = $date['this_week']->copy()->format($formatMonth).'-'.$date['this_week']->copy()->weekOfMonth;
                $prevDate   = $date['prev_week']->copy()->format($formatMonth).'-'.$date['prev_week']->copy()->weekOfMonth;
                $nextDate   = is_null($date['next_week']) ? NULL : $date['next_week']->copy()->format($formatMonth).'-'.$date['next_week']->copy()->weekOfMonth;
                break;
            // 월 단위
            case ConstantEnum::PERIOD['monthly'];
                $nowDate    = $date['this_month']->copy()->format($formatMonth);
                $prevDate   = $date['prev_month']->copy()->format($formatMonth);
                $nextDate   = is_null($date['next_month']) ? NULL : $date['next_month']->copy()->format($formatMonth);
                break;
        }

        // 학번 획득
        $std_id = $argStdId;

        // DB 조회
        $db = new Attendance();
        $result = NULL;
        if ($argPeriod === ConstantEnum::PERIOD['weekly']) {
            // 조회단위가 주인 경우 -> 이번주의 출석 기록을 조회
            $result = $db->selectAttendanceRecords($std_id,
                $date['this_week']->copy()->startOfWeek()->format($formatDay),
                $date['this_week']->copy()->endOfWeek()->format($formatDay));
        } else if ($argPeriod === ConstantEnum::PERIOD['monthly']) {
            // 조회단위가 달인 경우 -> 이번달의 출석기록을 조회
            $result = $db->selectAttendanceRecords($std_id,
                $date['this_month']->copy()->startOfMonth()->format($formatDay),
                $date['this_month']->copy()->endOfMonth()->format($formatDay));
        }

        if(($result->{ConstantEnum::ATTENDANCE['ada']} + $result->{ConstantEnum::ATTENDANCE['absence']}) <= 0) {
            return NULL;
        }

        // 출석율 계산
        $rate = ($result->{ConstantEnum::ATTENDANCE['ada']} /
                ($result->{ConstantEnum::ATTENDANCE['ada']} + $result->{ConstantEnum::ATTENDANCE['absence']})) * 100;

        return [
            'query_result'  => $result,
            'now_date'      => $nowDate,
            'prev_date'     => $prevDate,
            'next_date'     => $nextDate,
            'rate'          => $rate
        ];
    }
}
