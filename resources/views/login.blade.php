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
    <form method="post" action="login">
        <div>
            <div>
                <label for="student">학생</label>
                <input type="radio" name="type" value="student" id="student">
            </div>
            <div>
                <label for="professor">교수</label>
                <input type="radio" name="type" value="professor" id="professor">
            </div>
        </div>
        <div>
            id: <input type="text" name="id" value="{{ old('id') }}">
        </div>
        <div>
            pw: <input type="password" name="password">
        </div>
        <div>
            <button type="submit">Login</button>
        </div>
        <div><a href="{{ route('home.join') }}">회원가입</a></div>
        <div><a href="">아이디/비밀번호 찾기</a></div>
    </form>
@endsection