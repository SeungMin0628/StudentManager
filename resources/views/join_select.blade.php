<?php
/**
 * Created by PhpStorm.
 * 페이지 설명: 회원가입 유형 선택 페이지
 * User: Seungmin Lee
 * Date: 2018-03-16
 * Time: 오후 3:00
 */
?>
@extends('layouts.join_master')
@section('join.form')
    <div><a href="{{ route('home.join')."/{$user_type['student']}"}}">@lang('account.student')</a></div>
    <div><a href="{{ route('home.join')."/{$user_type['tutor']}" }}">@lang('account.prof_tutor')</a></div>
    <div><a href="{{ route('home.join')."/{$user_type['professor']}" }}">@lang('account.prof_general')</a></div>
@endsection