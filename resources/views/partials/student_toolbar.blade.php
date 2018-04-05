<?php
/**
 * 페이지 설명: <학생> 주 기능 링크 인터페이스
 * User: Seungmin Lee
 * Date: 2018-03-26
 * Time: 오후 7:10
 */
?>
<span>&lt;학생&gt;프로젝트 로고</span>
<span><a href="{{ route('student.info') }}">@lang('account.title')</a></span>
<span><a href="{{ route('student.attendance') }}">@lang('attendance.title')</a></span>
<span><a href="{{ route('student.lecture') }}">@lang('lecture.title')</a></span>
<span><a href="{{ route('student.counsel') }}">@lang('counsel.title')</a></span>
