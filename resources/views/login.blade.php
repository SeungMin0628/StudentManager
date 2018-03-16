<?php
/**
 * Created by PhpStorm.
 * Title    : 로그인 페이지
 * Explain  : 메인 로그인 페이지
 * User     : Seungmin Lee
 * Date     : 2018-03-15
 * Time     : 오후 3:44
 */
?>
<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Student Manager: Login</title>
    </head>
    <body>
        {{--@extends('master')--}}
        {{--@section('content')--}}
            <form method="post" action="login">
                <div>
                    <input type="radio" name="type" value="student">&nbsp;학생&nbsp;
                    <input type="radio" name="type" value="professor">&nbsp;교수
                </div>
                <div>
                    id: <input type="text" name="id" value="{{ old('id') }}">
                </div>
                <div>
                    pw: <input type="password" name="password">
                </div>
                <div>
                    <input type="checkbox" name="remember"> Remember Me
                </div>
                <div>
                    <button type="submit">Login</button>
                </div>
            </form>
        {{--@stop--}}
    </body>
</html>