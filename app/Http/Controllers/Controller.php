<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Psy\Exception\ErrorException;
use Illuminate\Support\Carbon;
use App\Http\Controllers\ConstantEnum;

class Controller extends BaseController {
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // 01. 공통 메서드 선언
    /**
     * 함수명:                         getWeeklyValue
     * 함수 설명:                      지난 주, 이번 주, 다음 주 값을 반환
     * 만든날:                         2018년 4월 08일
     *
     * 매개변수 목록
     * @param $argThisWeek:
     *
     * 지역변수 목록
     * null
     *
     * 반환값
     * @return                         array
     *
     * 예외
     * @throws ErrorException
     */
    public function getWeeklyValue($argThisWeek = null) {
        // 01. 변수 선언
        $thisWeek = null;
        $prevWeek = null;
        $nextWeek = null;

        // 매개인자가 없는 경우
        if(is_null($argThisWeek)) {
            // 이번주
            $thisWeek = today();

        // 매개인자가 있는 경우 => 데이터 형식을 지키고 있을 때
        } else if(preg_match("#^(19|20)\d{2}-(0[1-9]|1[012])-[1-6]$#", $argThisWeek)) {
            // 매개 데이터 분해
            $data = explode('-', $argThisWeek);

            // 이번주
            $thisWeek = Carbon::createFromDate($data[0], $data[1], 1);
            while($thisWeek->weekOfMonth <= $data[2]) {
                $thisWeek->addWeek();
            }
            $thisWeek->startOfWeek();
        } else {
            throw new ErrorException('aaa');
        }

        // 지난주
        $prevWeek = $thisWeek->copy()->subWeek();

        // 기준 시간대가 이번주보다 과거인 경우 다음주 생성
        if(today()->startOfWeek()->gt($thisWeek->copy()->startOfWeek())) {
            // 다음주
            $nextWeek = $thisWeek->copy()->addWeek();
        }

        return [
            'prev_week'     => $prevWeek,
            'this_week'     => $thisWeek,
            'next_week'     => $nextWeek
        ];
    }

    /**
     * 함수명:                         getWeeklyValue
     * 함수 설명:                      지난 달, 이번 달, 다음 달 값을 반환
     * 만든날:                         2018년 4월 08일
     *
     * 매개변수 목록
     * @param $argThisMonth:           기준 달 값
     *
     * 지역변수 목록
     * null
     *
     * 반환값
     * @return                         array
     *
     * 예외
     * @throws ErrorException
     */
    public function getMonthlyValue($argThisMonth = null) {
        // 01. 변수 선언
        $thisMonth = null;
        $prevMonth = null;
        $nextMonth = null;

        // 매개인자가 없는 경우
        if(is_null($argThisMonth)) {
            // 이번주
            $thisMonth = today();

            // 매개인자가 있는 경우 => 데이터 형식을 지키고 있을 때
        } else if(preg_match("#^(19|20)\d{2}-(0[1-9]|1[012])$#", $argThisMonth)) {
            // 매개 데이터 분해
            $data = explode('-', $argThisMonth);

            // 이번주
            $thisMonth = Carbon::createFromDate($data[0], $data[1], 1);
        } else {
            throw new ErrorException();
        }

        // 지난달
        $prevMonth = $thisMonth->copy()->subMonth();

        // 기준 시간대가 이번달보다 과거인 경우 다음달 생성
        if(today()->startOfMonth()->gt($thisMonth->copy()->startOfMonth())) {
            // 다음달
            $nextMonth = $thisMonth->copy()->addMonth();
        }

        return [
            'prev_month'        => $prevMonth,
            'this_month'        => $thisMonth,
            'next_month'        => $nextMonth
        ];
    }

    /**
     * 함수명:                         getTermValue
     * 함수 설명:                      지난 학기, 이번 학기, 다음 학기 값을 반환
     * 만든날:                         2018년 4월 08일
     *
     * 매개변수 목록
     * @param $argThisTerm:            기준 학기
     *
     * 지역변수 목록
     * null
     *
     * 반환값
     * @return                         array
     *
     * 예외
     * @throws ErrorException
     */
    public function getTermValue($argThisTerm = null){
        // 01. 변수 선언
        $year       = null;
        $term       = null;
        $nowTerm    = null;
        $thisTerm   = null;
        $prevTerm   = null;
        $nextTerm   = null;

        // 현재 학기 설정
        switch(today()->month) {
            // 겨울방학
            case 1:
            case 2:
                $nowTerm = ConstantEnum::TERM['winter_vacation'];
                break;
            case 3:
            case 4:
            case 5:
            case 6:
                $nowTerm = ConstantEnum::TERM['1st_term'];
                break;
            case 7:
            case 8:
                $nowTerm = ConstantEnum::TERM['summer_vacation'];
                break;
            case 9:
            case 10:
            case 11:
            case 12:
                $nowTerm = ConstantEnum::TERM['2nd_term'];
                break;
        }
        if(is_null($argThisTerm)) {
            $year = today()->year;
            $term = $nowTerm;

        } else if(preg_match("#^(19|20)\d{2}-[1-4]$#", $argThisTerm)) {
            $data = explode('-', $argThisTerm);

            $year = $data[0];
            $term = $data[1];
        } else {
            throw new ErrorException();
        }

        // 조회학기 설정
        $thisTerm = "{$year}-{$term}";

        // 지난 학기 설정
        if($term == ConstantEnum::TERM['1st_term']) {
            $prevTerm = ($year - 1).'-'.ConstantEnum::TERM['winter_vacation'];
        } else {
            $prevTerm = $year.'-'.($term - 1);
        }

        // 조회 연도와 학기가 현재 연도 학기보다 크다면 => 다음학기 생성하지 않음
        if(!($year >= today()->year && $term >= $nowTerm)) {
            // 다음 학기 설정
            if($term == ConstantEnum::TERM['winter_vacation']) {
                $nextTerm = ($year + 1).'-'.ConstantEnum::TERM['1st_term'];
            } else {
                $nextTerm = $year.'-'.($term + 1);
            }
        }

        // 반환
        return [
            'prev_term'     => $prevTerm,
            'this_term'     => $thisTerm,
            'year'          => $year,
            'term'          => __('lecture.'.ConstantEnum::TERM[$term]),
            'next_term'     => $nextTerm
        ];
    }

    // 연도에 대한 페이지네이션 값을 반환
    public function getYearValue($argThisYear = null) {
        // 01. 변수 설정
        $prevYear = null;
        $thisYear = null;
        $nextYear = null;

        // 이번 연도 설정
        if(is_null($argThisYear)) {
            $thisYear = today();
        } else if(preg_match("#^(19|20)\d{2}$#", $argThisYear)) {
            $thisYear = Carbon::createFromDate($argThisYear, 1, 1);
        } else {
            throw new ErrorException();
        }

        // 지난 연도 설정
        $prevYear = $thisYear->copy()->subYear();

        // 설정한 이번 연도가 현재보다 과거인 경우 => 다음 연도 설정
        if(today()->year > $thisYear->year) {
            $nextYear = $thisYear->copy()->addYear();
        }

        // 반환
        return [
            'prev_year' => $prevYear,
            'this_year' => $thisYear,
            'next_year' => $nextYear
        ];
    }
}
