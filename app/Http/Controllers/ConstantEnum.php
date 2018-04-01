<?php

namespace App\Http\Controllers;

/**
 * 클래스명:                       ConstantEnum
 * @package                        App\Http\Controllers
 * 클래스 설명:                    시스템 전반에 사용되는 상수 목록을 정의하는 클래스
 * 만든이:                         3-WDJ 8조 春目指す 1401213 이승민
 * 만든날:                         2018년 3월 30일
 *
 * 상수 목록
 *      USER_TYPE :                사용자 유형을 정의
 *      PERIOD :                   기간 정보를 정의
 *      ATTENDANCE :               출석 관련 정보를 정의
 */
class ConstantEnum {
    //  사용자 유형을 정의
    const USER_TYPE     = [
        'student'       => 'student',
        'tutor'         => 'tutor',
        'professor'     => 'professor'
    ];

    // 기간 정보를 정의
    const PERIOD        = [
        'weekly'        => 'weekly',
        'monthly'       => 'monthly',
        'termly'        => 'termly',
        'yearly'        => 'yearly'
    ];

    // 출석 관련 정보를 정의
    const ATTENDANCE    = [
        'ada'           => 'attendance',
        'n_ada'         => 'nearest_attendance',
        'late'          => 'late',
        'n_late'        => 'nearest_late',
        'absence'       => 'absence',
        'n_absence'     => 'nearest_absence',
        'early'         => 'early',
        'n_early'       => 'nearest_early'
    ];
}