<?php
/**
 * 페이지 설명: <지도교수> 내 지도반 생성
 * User: Seungmin Lee
 * Date: 2018-04-02
 * Time: 오전 11:47
 */
?>
@extends('layouts.tutor_master')
@section('body.section')
    <form method="get" action="{{ route('tutor.myclass.create') }}">
        <div>
            <div>
                <label for="input_class_name">반 이름</label>
                <input type="text" id="input_class_name" name="name" required>
                {!! $errors->first('name', '<span class="form-error">:message</span>') !!}
            </div>
            <div>
                <label for="input_school_time">등교 시간</label>
                <input type="time" id="input_school_time" name="school_time" required>
                {!! $errors->first('school_time', '<span class="form-error">:message</span>') !!}
            </div>
            <div>
                <label for="input_home_time">하교 시간</label>
                <input type="time" id="input_home_time" name="home_time" required>
                {!! $errors->first('home_time', '<span class="form-error">:message</span>') !!}
            </div>
            <input type="submit" value="@lang('interface.submit')">
        </div>
    </form>
@endsection