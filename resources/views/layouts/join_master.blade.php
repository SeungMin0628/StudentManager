<?php
/**
 * Created by PhpStorm.
 * User: Seungmin Lee
 * Date: 2018-03-16
 * Time: 오후 2:46
 */
?>
@extends('layouts.master')
@section('body.header')
    <h1 align="left">@lang('interface.join')</h1>
    <h1 align="right">
        @if(isset($type))
            {{ $type }}
        @endif
    </h1>
    <hr/>
@endsection
@section('body.section')
    @yield('join.form')
@endsection