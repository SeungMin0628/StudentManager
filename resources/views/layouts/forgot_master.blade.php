<?php
/**
 * Created by PhpStorm.
 * 페이지 설명: 아이디/비밀번호 찾기 페이지의 상위 부모 페이지
 * User: Seungmin Lee
 * Date: 2018-03-29
 * Time: 오후 7:11
 */
?>
@extends('layouts.master')
@section('body.header')
    <h1 align="left">@lang('interface.forgot')</h1>
    @if(isset($type))
        <h1 align="right">{{ $type }}</h1>
    @endif
    <hr/>
@endsection
