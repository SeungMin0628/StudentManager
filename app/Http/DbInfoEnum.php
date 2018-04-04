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
    // 교수 테이블
    const PROFESSORS = [
        't_name'        => 'professors',
        'id'            => 'id',
        'manager'       => 'manager',
        'expire'        => 'expire_date',
        'pw'            => 'password',
        'name'          => 'name',
        'phone'         => 'phone',
        'email'         => 'email',
        'office'        => 'office',
        'f_p'           => 'face_photo'
    ];

    // 반 테이블
    const GROUPS = [
        't_name'        => 'groups',
        'id'            => 'id',
        'tutor'         => 'tutor',
        'name'          => 'name',
        's_time'        => 'school_time',
        'h_time'        => 'home_time'
    ];

    // 학생 테이블
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

    // 출석 테이블
    const ATTENDANCES = [
        't_name'        => 'attendances' ,
        'reg_date'      => 'reg_date',
        'std_id'        => 'std_id',
        'come'          => 'come_school',
        'leave'         => 'leave_school',
        'absence'       => 'absence_flag'
    ];

    // 하교 테이블
    const LEAVE_SCHOOLS = [
        't_name'        => 'leave_schools',
        'id'            => 'id',
        'reg_time'      => 'reg_time',
        'early'         => 'early_flag',
        'clf'           => 'classification'
    ];

    // 등교 테이블
    const COME_SCHOOLS = [
        't_name'        => 'come_schools',
        'id'            => 'id',
        'reg_time'      => 'reg_time',
        'late'          => 'lateness_flag',
        'clf'           => 'classification'
    ];

    // 등/하교 유형 테이블
    const CLASSIFICATIONS = [
        't_name'        => 'classifications',
        'id'            => 'id',
        'content'       => 'content'
    ];

    // 학생 수강목록 테이블
    const SIGN_UP_LISTS = [
        't_name'        => 'sign_up_lists',
        'id'            => 'id',
        "lec"           => 'lecture_id',
        's_id'          => 'std_id',
        'ach'           => 'achievement'
    ];

    // 개설 강의 목록 테이블
    const LECTURES = [
        't_name'        => 'lectures',
        'id'            => 'id',
        'sub_id'        => 'subject_id',
        'divided'       => 'divided_class_id',
        'prof'          => 'professor',
        'ada_ref'       => 'attendance_reflection',
        'mid_ref'       => 'midterm_reflection',
        'fin_ref'       => 'final_reflection',
        'tsk_ref'       => 'task_reflection',
        'quz_ref'       => 'quiz_reflection'
    ];

    // 성적 유형 테이블
    const SCORES = [
        't_name'        => 'scores',
        'id'            => 'id',
        'lecture'       => 'lecture_id',
        'reg_date'      => 'reg_date',
        'type'          => 'type',
        'content'       => 'content',
        'prefect'       => 'perfect_score'
    ];

    // 취득 점수 테이블
    const GAINED_SCORES = [
        't_name'        => 'gained_scores',
        'type'          => 'score_type',
        'std_id'        => 'std_id',
        'score'         => 'score',
    ];

    const SUBJECTS = [
        't_name'        => 'subjects',
        'year'          => 'year',
        'term'          => 'term',
        'group'         => 'group_id',
        'id'            => 'id',
        'name'          => 'name',
        'div'           => 'division_flag'
    ];
}