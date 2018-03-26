<?php
/**
 * Created by PhpStorm.
 * 페이지 설명: 메인 로그인 페이지
 * User: Seungmin Lee
 * Date: 2018-03-15
 * Time: 오후 3:44
 */
?>
@extends('layouts.master')
@section('body.section')
    <form method="post" action="{{ route('home.login') }}">
        {!! csrf_field() !!}
        <div>
            <div>
                <label for="student">학생</label>
                <input type="radio" name="type" value="{{ $user_type['student'] }}" id="student" required>
                {!! $errors->first('student', '<span class="form-error">:message</span>') !!}
            </div>
            <div>
                <label for="professor">교수</label>
                <input type="radio" name="type" value="{{ $user_type['professor'] }}" id="professor">
                {!! $errors->first('professor', '<span class="form-error">:message</span>') !!}
            </div>
        </div>
        <div>
            <label for="id">아이디</label>
            <input type="text" name="id" id="id" value="{{ old('id') }}" required>
            {!! $errors->first('id', '<span class="form-error">:message</span>') !!}
        </div>
        <div>
            <label for="password">비밀번호</label>
            <input type="password" id="password" name="password" required>
            {!! $errors->first('password', '<span class="form-error">:message</span>') !!}
        </div>
        <div>
            <button type="submit">Login</button>
        </div>
        <div><a href="{{ route('home.join') }}">회원가입</a></div>
        <div><a href="">아이디/비밀번호 찾기</a></div>
    </form>
@endsection