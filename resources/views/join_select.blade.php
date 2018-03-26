<?php
/**
 * Created by PhpStorm.
 * 페이지 설명: 회원가입 유형 선택 페이지
 * User: Seungmin Lee
 * Date: 2018-03-16
 * Time: 오후 3:00
 */
?>
@extends('layouts.join')
@section('join.form')
    <div><a href="{{ route('home.join')."/{$user_type['student']}"}}">학생</a></div>
    <div><a href="{{ route('home.join')."/{$user_type['tutor']}" }}">지도교수</a></div>
    <div><a href="{{ route('home.join')."/{$user_type['professor']}" }}">교과목교수</a></div>
@endsection