<?php
/**
 * Created by PhpStorm.
 * User: Seungmin Lee
 * Date: 2018-03-26
 * Time: 오후 7:10
 */
?>
<table border="1">
    <tbody>
    <tr>
        {{-- 사이트 로고 -> 메인 페이지로 이동 --}}
        <th rowspan="2">
            <span><a href="{{ route('professor.index') }}">&lt;교과목교수&gt;프로젝트 로고</a></span>
        </th>

        {{-- 각 기능의 타이틀 - 중요한거 아님 --}}
        <td colspan="3">@lang('account.title')</td>
        <td colspan="5">@lang('lecture.class')</td>
        <td colspan="2">@lang('counsel.title')</td>
    </tr>
    <tr>
        {{-- 계정관리 기능별 링크 --}}
            <!-- 내 정보 열람 -->
        <td><a href="">@lang('account.myinfo')</a></td>
            <!-- 계정 정보 수정 -->
        <td><a href="">@lang('account.myinfo_update')</a></td>
            <!-- 간편계정 관리 -->
        <td><a href="">@lang('account.account_sync_manage')</a></td>

        {{-- 수강반 관리 --}}
            <!-- 출석 체크 -->
        <td><a href="{{ route('professor.lecture.attendance.check') }}">@lang('attendance.check')</a></td>
            <!-- 출석 내역 확인 -->
        <td><a href="">@lang('attendance.select_records')</a></td>
            <!-- 성적 등록 -->
        <td><a href="{{ route('professor.scores.store.main') }}">@lang('lecture.store')</a></td>
            <!-- 성적 조회 -->
        <td><a href="">@lang('lecture.select')</a></td>
            <!-- 성적 반영비 수정 -->
        <td><a href="">@lang('lecture.update_reflection')</a></td>

        {{-- 상담 관리 --}}
            <!-- 받은 상담요청 확인 -->
        <td><a href="">@lang('counsel.show_reception')</a></td>
            <!-- 상담 요청하기 -->
        <td><a href="">@lang('counsel.ask')</a></td>
    </tr>
    </tbody>
</table>