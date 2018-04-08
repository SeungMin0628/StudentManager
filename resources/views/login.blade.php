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
            <span>
                <label for="student">@lang('account.student')</label>
                <input type="radio" name="type" value="{{ $user_type['student'] }}" id="student"
                       @if(old('type') == $user_type['student']) checked @endif required>
                {!! $errors->first('student', '<span class="form-error">:message</span>') !!}
            </span>
            <span>
                <label for="professor">@lang('account.professor')</label>
                <input type="radio" name="type" value="{{ $user_type['professor'] }}" id="professor"
                        @if(old('type') == $user_type['professor']) checked @endif>
                {!! $errors->first('professor', '<span class="form-error">:message</span>') !!}
            </span>
        </div>
        <div>
            <label for="id">@lang('account.id')</label>
            <input type="text" name="id" id="id" value="{{ old('id') }}" required>
            {!! $errors->first('id', '<span class="form-error">:message</span>') !!}
        </div>
        <div>
            <label for="password">@lang('account.pw')</label>
            <input type="password" id="password" name="password" required>
            {!! $errors->first('password', '<span class="form-error">:message</span>') !!}
        </div>
        <div>
            <button type="submit">@lang('interface.login')</button>
        </div>
        <div><a href="{{ route('home.join') }}">@lang('interface.join')</a></div>
        <div><a href="{{ route('home.forgot') }}">@lang('interface.forgot')</a></div>
    </form>
@endsection