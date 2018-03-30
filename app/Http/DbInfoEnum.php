<?php
/**
 * Created by PhpStorm.
 * User: Seungmin Lee
 * Date: 2018-03-30
 * Time: 오후 7:40
 */

namespace App\Http;

/**
 * 클래스명:                       DbInfoEnum
 * @package                        App\Http
 * 클래스 설명:                    데이터베이스에 정의된 테이블과 각 칼럼에 대한 이름 정보를 표기하는 클래스
 * 만든이:                         3-WDJ 8조 春目指す 1401213 이승민
 * 만든날:                         2018년 3월 30일
 *
 * 상수 목록
 */
class DbInfoEnum {
    const STUDENTS = [
        't_name'        => 'students',
        'id'            => 'id',
        'group'         => 'group',
        'pw'            => 'password',
        'name'          => 'name',
        'phone'         => 'phone',
        'email'         => 'email',
        'f_p'           => 'face_photo'
    ];

    const ATTENDANCES = [
        't_name'        => 'attendances' ,
        'reg_date'      => 'reg_date',
        'std_id'        => 'std_id',
        'come'          => 'come_school',
        'leave'         => 'leave_school',
        'absence'       => 'absence_flag'
    ];

    const LEAVE_SCHOOLS = [
        't_name'        => 'leave_schools',
        'id'            => 'id',
        'reg_time'      => 'reg_time',
        'early'         => 'early_flag',
        'clf'           => 'classification'
    ];

    const COME_SCHOOLS = [
        't_name'        => 'come_schools',
        'id'            => 'id',
        'reg_time'      => 'reg_time',
        'late'          => 'lateness_flag',
        'clf'           => 'classification'
    ];

    const CLASSIFICATIONS = [
        't_name'        => 'classifications',
        'id'            => 'id',
        'content'       => 'content'
    ];
}