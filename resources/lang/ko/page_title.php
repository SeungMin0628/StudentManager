<?php
/**
 * 제목:              한국어: 페이지 제목
 * 설명:              다국어 지원을 위한 한국어 패키지 : 페이지 제목 정의
 * 만든이:            3-WDJ 8조 春目指す 1401213 이승민
 * 만든날:            2018년 3월 28일
 */
return [
    // 01. 홈 컨트롤러에서 제공하는 페이지
    'home_index'            => '홈페이지',
    'home_join_select'      => '회원가입: 유형선택',
    'home_join_student'     => '회원가입: 학생',
    'home_join_tutor'       => '회원가입: 지도교수',
    'home_join_professor'   => '회원가입: 교과목교수',
    'home_forgot_select'    => '회원정보찾기: 유형 선택',

    // 02. 학생 컨트롤러에서 제공하는 페이지
    'student_index'             => '학생: 홈페이지',
    'student_info'              => '학생: 계정관리',
    'student_attendance'        => '학생: 출결관리',
    'student_lecture'           => "학생: 학업관리",
    'student_counsel'           => "학생: 상담관리",

    // 03. 지도교수 컨트롤러에서 제공하는 페이지
    'tutor_index'               => "지도교수: 홈페이지",

    'tutor_myclass_create'      => '지도교수: 내 지도반 만들기',
    'tutor_myclass_manage'      => '지도교수: 내 지도학생 관리',

    // 04. 교과목교수 컨트롤러에서 제공하는 페이지
    'professor_index'               => '교과목교수: 홈페이지',
    'professor_myinfo_read'         => '교과목교수: 내 정보 확인',
    'professor_myinfo_update'       => '교과목교수: 정보 수정',
    'professor_myinfo_account'      => '교과목교수: 간편계정 관리',

    'professor_my_student_details'  => '교과목교수: :name 학생 상세정보',
    'professor_check_attendance'    => '교과목교수: 출석체크',

    'professor_score_store_main'    => '교과목교수: 성적등록',

    'professor_counsel'             => '교과목교수: 상담관리',
];