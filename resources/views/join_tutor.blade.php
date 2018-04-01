<?php
/**
 * Created by PhpStorm.
 * 페이지 설명: 지도교수 회원가입 페이지
 * User: Seungmin Lee
 * Date: 2018-03-28
 * Time: 오후 7:25
 */
?>
@extends('layouts.join_master')
@section('join.form')
    <form action="{{ route('tutor.store') }}" method="post">
        {{-- CSRF 공격 방지를 위한 필드 생성. 절대 삭제하지 말 것! --}}
        {!! csrf_field() !!}

        {{-- 학번 입력 필드 --}}
        <div class="form-group {{ $errors->has('id') || $errors->has('id_check') ? 'has-error' : '' }}">
            <label for="std_id">@lang('account.id')</label>
            <input type="text" id="id" name="id" required value="{{ old('id') }}">
            <input type="button" id="id_check_button" value="@lang('interface.check')">
            <input type="hidden" id="id_check" name="id_check" value="0">
            {!! $errors->first('id', '<span class="form-error">:message</span>') !!}
            {!! $errors->first('id_check', '<span class="form-error">:message</span>') !!}
        </div>

        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
            <label for="name">@lang('account.name')</label>
            <input type="text" id="name" name="name" required>
            {!! $errors->first('name', '<span class="form-error">:message</span>') !!}
        </div>

        <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
            <label for="password">@lang('account.password')</label>
            <input type="password" id="password" name="password" required>
            {!! $errors->first('password', '<span class="form-error">:message</span>') !!}
        </div>

        <div class="form-group {{ $errors->has('check_password') ? 'has-error' : '' }}">
            <label for="check_password">@lang('account.check_password')</label>
            <input type="password" id="check_password" name="check_password" placeholder="@lang('interface.check_password')" required>
            {!! $errors->first('check_password', '<span class="form-error">:message</span>') !!}
        </div>

        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
            <label for="email">@lang('account.email')</label>
            <input type="email" id="email" name="email" required placeholder="example@example.com">
            {!! $errors->first('email', '<span class="form-error">:message</span>') !!}
        </div>

        <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
            <label for="phone">@lang('account.phone')</label>
            <input type="tel" id="phone" name="phone" placeholder="@lang('interface.phone')" required>
            {!! $errors->first('phone', '<span class="form-error">:message</span>') !!}
        </div>

        <div class="form-group {{ $errors->has('office') ? 'has-error' : '' }}">
            <label for="office">@lang('account.office')</label>
            <input type="text" id="office" name="office" required>
            {!! $errors->first('office', '<span class="form-error">:message</span>') !!}
        </div>

        <div><input type="submit" value="@lang('interface.join')"></div>
    </form>
    <div><a href="{{route('home.index')}}">@lang('interface.link_main_page')</a></div>
@endsection
@section('script')
    <script language="JavaScript">
        /**
         * 함수명:                         x
         * 함수 설명:                      사용자가 입력한 아이디의 사용 가능 여부를 조회
         * 만든날:                         2018년 3월 23일
         *
         * 매개변수 목록
         * null
         *
         * 지역변수 목록
         * requestObj(Object):              AJAX 통신에 사용하는 객체. 웹 브라우저에 따라 다르게 할당된다.
         * url(string):                     메시지를 전송하는 도착지
         * sendMessage(string):             송신 메시지
         * inputStdId(Element):             학번 INPUT Text Element
         * inputName(Element):              학생 이름 INPUT Text Element
         *
         * 반환값
         * null
         */
        document.getElementById('id_check_button').addEventListener('click', function() {
            // 01. 변수 정의
            let requestObj  = null;
            let url         = '{{ route('tutor.check_join') }}';
            let sendMessage = '';
            let inputId     = document.getElementById('id');

            // 웹 브라우저에 따른 AJAX 통신 객체 할당
            if(window.XMLHttpRequest) {
                requestObj = new XMLHttpRequest();
            } else if(window.ActiveXObject) {
                requestObj = new ActiveXObject("Microsoft.XMLHTTP");
            }

            // 02. 함수 설정
            requestObj.onreadystatechange = function() {
                if(requestObj.readyState === 4 && requestObj.status === 200) {
                    let message = JSON.parse(requestObj.responseText)['msg'];

                    if(message === 'FALSE') {
                        // 이미 존재하는 아이디인 경우 => 경고 메시지 출력
                        alert('@lang('message.join_unusable_prof_id')');
                        inputId.value = '';
                    } else if(message === '') {
                        // 서버측의 응답 메시지가 없을 경우
                    } else if(message === 'TRUE') {
                        // 사용가능한 아이디인 경우 => 아이디 확인 여부를 TRUE
                        alert('@lang('message.join_usable_id')');
                        document.getElementById('id_check').setAttribute('value', '1');
                    }
                } else {
                    /* 서버와의 통신 진행중... */
                }
            };

            // 03. 송신문 정의
            let id = inputId.value;
            sendMessage += '_token={{ csrf_token() }}';
            sendMessage += `&id=${id}`;

            // 04. 송신
            requestObj.open('POST', url, true);
            requestObj.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            requestObj.send(sendMessage);
        });
    </script>
@endsection