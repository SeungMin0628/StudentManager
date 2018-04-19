<?php
/**
 * 페이지 설명: <지도교수> 최상위 기능 접속용 툴바 페이지
 * User: Seungmin Lee
 * Date: 2018-03-26
 * Time: 오후 7:10
 */
?>
<!-- 메뉴 테이블 -->
<table border="1">
    <tbody>
        <!-- 최상위 분류: 각 기능의 제목-->
        <tr>
            <th rowspan="3"><a href="{{ route("tutor.index") }}">&lt;지도교수&gt;프로젝트 로고</a></th>
            <th colspan="3">@lang('account.title')</th><!-- 계정관리 -->
            <th colspan="4">@lang('myclass.title')</th><!-- 지도반 -->
            <th colspan="2">@lang('counsel.title')</th><!-- 상담관리 -->
            <th colspan="5">@lang('config.title')</th><!-- 관리&설정 -->
        </tr>
        <!-- 차상위 분류 : 각 기능의 세부 분류 -->
        <tr>
            <!-- 회원정보 관리 -->
            <td rowspan="2">@lang('account.myinfo')</td><!-- 내 정보 -->
            <td rowspan="2">@lang('account.myinfo_update')</td><!-- 정보 수정 -->
            <td rowspan="2">@lang('account.account_sync_manage')</td><!-- 간편 계정 -->

            <!-- 내 지도반 관리 -->
            <td colspan="2">@lang('attendance.title')</td><!-- 출결 관리 -->
            <td rowspan="2"><a href="{{ route('tutor.myclass.manage') }}">@lang('myclass.manage_student')</a></td><!-- 학생 관리 -->
            <td rowspan="2"><a href="{{ route('tutor.myclass.needcare') }}">@lang('myclass.config_need_care')</a></td><!-- 알림 설정 -->

            <!-- 상담 관리 -->
            <td rowspan="2">@lang('counsel.show_reception')</td> <!-- 받은 요청 -->
            <td rowspan="2">@lang('counsel.ask')</td><!-- 요청하기 -->

            <!-- 설정&관리 -->
            <td colspan="2">정보 등록</td><!-- 정보등록 -->
            <td colspan="2">교과목교수</td><!-- 교과목교수 -->
            <td rowspan="2">@lang('myclass.manage_attendance_time')</td><!-- 요청하기 -->
        </tr>
        <!-- 최하위 분류 : 각 기능의 세부 분류 2-->
        <tr>
            <!-- 내 지도반 관리 => 출결관리 -->
            <td><a href="{{ route('tutor.myclass.attendance') }}">@lang('myclass.check_attendance')</a></td><!-- 오늘 등하교 출결 보기 -->
            <td>@lang('myclass.today_positions')</td><!-- 일일 위치확인 -->

            <!-- 설정&관리 => 정보 등록 -->
            <td><a href="{{ route('tutor.config.store.student') }}">@lang('myclass.store_student')</a></td><!-- 학생 등록 -->
            <td>@lang('myclass.store_timetable')</td><!-- 시간표 등록 -->

            <!-- 설정&관리 => 교과목교수 -->
            <td>@lang('myclass.store_professor')</td><!-- 계정 생성 -->
            <td>@lang('myclass.manage_professor')</td><!-- 계정 관리 -->
        </tr>
    </tbody>
</table>