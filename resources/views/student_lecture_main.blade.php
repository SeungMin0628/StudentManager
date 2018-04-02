<?php
/**
 * Created by PhpStorm.
 * 페이지 설명: <학생> 학업관리 메인 페이지
 * User: Seungmin Lee
 * Date: 2018-04-02
 * Time: 오후 6:47
 */
?>
@extends('layouts.student_master')
@section('body.section')
    <div>
        <span>@lang('lecture.title')</span>
        <span>
            <input type="button" value="@lang('pagination.previous')">
            <span>2018년 1학기</span>
            <input type="button" value="@lang('pagination.next')">
        </span>
    </div>
    <div>
        {{--@forelse($items as $item)
        @empty
        @endforelse--}}
    </div>
@endsection
