<?php
/**
 * Created by PhpStorm.
 * 페이지 설명: 학생 회원가입 페이지
 * User: Seungmin Lee
 * Date: 2018-03-16
 * Time: 오후 7:25
 */
?>
@extends('layouts.join')
@section('join.form')
    <form action="{{ route('student.store') }}" method="post">
        {!! csrf_field() !!}

        <div class="form-group {{ $errors->has('std_id') ? 'has-error' : '' }}">
            <label for="std_id">학번</label>
            <input type="text" id="std_id" name="std_id" placeholder="1234567" value="{{ old('std_id') }}" class="form-control">
            <input type="button" value="확인">
            {!! $errors->first('std_id', '<span class="form-error">:message</span>') !!}
        </div>

        <div class="form-group {{ $errors->has('name' ? 'has-error' : '') }}">
            <label for="name">이름</label>
            <input type="text" id="name" name="name">
            {!! $errors->first('name', '<span class="form-error">:message</span>') !!}
        </div>

        <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
            <label for="password">비밀번호</label>
            <input type="password" id="password" name="password">
            {!! $errors->first('password', '<span class="form-error">:message</span>') !!}
        </div>

        <div class="form-group {{ $errors->has('check_password' ? 'has-error' : '') }}">
            <label for="check_password">비밀번호 확인</label>
            <input type="password" id="check_password" name="check_password">
            {!! $errors->first('check_password', '<span class="form-error">:message</span>') !!}
        </div>

        <div class="form-group {{ $errors->has('email' ? 'has-error' : '') }}">
            <label for="email">이메일</label>
            <input type="email" id="email" name="email">
            {!! $errors->first('email', '<span class="form-error">:message</span>') !!}
        </div>

        <div class="form-group {{ $errors->has('phone' ? 'has-error' : '') }}">
            <label for="phone">전화번호</label>
            <input type="text" id="phone" name="phone">
            {!! $errors->first('phone', '<span class="form-error">:message</span>') !!}
        </div>

        <div><input type="submit" value="회원가입"></div>
    </form>
@endsection