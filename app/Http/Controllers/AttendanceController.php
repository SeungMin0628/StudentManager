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
        $date = today();
        $nowDate = NULL;
        $prevDate = NULL;
        $nextDate = NULL;
        $formatDay = "Y-m-d";
        $formatMonth = "Y-m";
        if (!is_null($argDate)) {
            $argDate = explode('-', $argDate);
            // 검색단위가 week 이고, 기간을 parse 한 결과 배열 길이가 3일 때
            if ($argPeriod === ConstantEnum::PERIOD['weekly'] && sizeof($argDate) == 3) {
                $date->year  = $argDate[0];
                $date->month = $argDate[1];
                $date->day   = ($argDate[2] - 1) * 7 + 1;
            } // 검색단위가 month 이고, 기간을 parse 한 결과 배열 길이가 2일 때
            else if ($argPeriod === ConstantEnum::PERIOD['monthly'] && sizeof($argDate) == 2) {
                $date->year = $argDate[0];
                $date->month = $argDate[1];
            } else {
                throw new ErrorException();
            }
        }

        // 각 기간에 대한 문자열 추출
        switch ($argPeriod) {
            case ConstantEnum::PERIOD['weekly'];
                $nowDate = $date->copy()->format('Y-m-') . $date->copy()->weekOfMonth;
                $prevDate = $date->copy()->subWeek(1)->format('Y-m-') . $date->copy()->subWeek(1)->weekOfMonth;

                $same_week_flag = 0;    // 다음주가 이번주와 같은 주인지 판단
                if($date->copy()->addDay(6)->startOfWeek() === $date->copy()->startOfWeek()) {
                    $same_week_flag = 1;
                }

                $nextDate = today()->lte($date) ? NULL :
                    $date->copy()->addWeek(1 + $same_week_flag)->format('Y-m-') . $date->copy()->addWeek(1)->weekOfMonth;
                break;
            case ConstantEnum::PERIOD['monthly'];
                $nowDate = $date->copy()->format($formatMonth);
                $prevDate = $date->copy()->subMonth(1)->format($formatMonth);
                $nextDate = today()->lte($date) ? NULL : $date->copy()->addMonth(1)->format($formatMonth);
                break;
        }

        // 학번 획득
        $std_id = $argStdId;

        // DB 조회
        $db = new Attendance();
        $result = NULL;
        if ($argPeriod === ConstantEnum::PERIOD['weekly']) {
            $result = $db->selectAttendanceRecords($std_id,
                $date->copy()->startOfWeek()->format($formatDay), $date->copy()->endOfWeek()->format($formatDay));
        } else if ($argPeriod === ConstantEnum::PERIOD['monthly']) {
            $result = $db->selectAttendanceRecords($std_id,
                $date->copy()->startOfMonth()->format($formatDay), $date->copy()->endOfMonth()->format($formatDay));
        }

        if(($result->{ConstantEnum::ATTENDANCE['ada']} + $result->{ConstantEnum::ATTENDANCE['absence']}) <= 0) {
            return NULL;
        }

        // 출석율 계산
        $rate = null;
        if ($argPeriod == ConstantEnum::PERIOD['weekly']) {
            $rate = ($result->{ConstantEnum::ATTENDANCE['ada']} / 7) * 100;
        } else if ($argPeriod == ConstantEnum::PERIOD['monthly']) {
            $rate = ($result->{ConstantEnum::ATTENDANCE['ada']} / $date->copy()->endOfMonth()->format('d')) * 100;
        }

        return [
            'query_result'  => $result,
            'now_date'      => $nowDate,
            'prev_date'     => $prevDate,
            'next_date'     => $nextDate,
            'rate'          => $rate
        ];
    }
}
