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
                <label for="student">@lang('home.student')</label>
                <input type="radio" name="type" value="{{ $user_type['student'] }}" id="student" required>
                {!! $errors->first('student', '<span class="form-error">:message</span>') !!}
            </div>
            <div>
                <label for="professor">@lang('home.professor')</label>
                <input type="radio" name="type" value="{{ $user_type['professor'] }}" id="professor">
                {!! $errors->first('professor', '<span class="form-error">:message</span>') !!}
            </div>
        </div>
        <div>
            <label for="id">@lang('home.id')</label>
            <input type="text" name="id" id="id" value="{{ old('id') }}" required>
            {!! $errors->first('id', '<span class="form-error">:message</span>') !!}
        </div>
        <div>
            <label for="password">@lang('home.password')</label>
            <input type="password" id="password" name="password" required>
            {!! $errors->first('password', '<span class="form-error">:message</span>') !!}
        </div>
        <div>
            <button type="submit">@lang('home.login')</button>
        </div>
        <div><a href="{{ route('home.join') }}">@lang('home.join')</a></div>
        <div><a href="">@lang('home.forgot')</a></div>
    </form>
@endsection