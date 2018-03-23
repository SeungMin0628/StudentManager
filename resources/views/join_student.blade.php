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
            <input type="text" id="std_id" name="std_id" required placeholder="1234567" value="{{ old('std_id') }}" class="form-control">
            <input type="button" id="std_id_check" value="확인">
            {!! $errors->first('std_id', '<span class="form-error">:message</span>') !!}
        </div>

        <div class="form-group {{ $errors->has('name' ? 'has-error' : '') }}">
            <label for="name">이름</label>
            <input type="text" id="name" name="name" readonly>
            {!! $errors->first('name', '<span class="form-error">:message</span>') !!}
        </div>

        <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
            <label for="password">비밀번호</label>
            <input type="password" id="password" name="password" required>
            {!! $errors->first('password', '<span class="form-error">:message</span>') !!}
        </div>

        <div class="form-group {{ $errors->has('check_password' ? 'has-error' : '') }}">
            <label for="check_password">비밀번호 확인</label>
            <input type="password" id="check_password" name="check_password" placeholder="비밀번호 한 번 더 입력" required>
            {!! $errors->first('check_password', '<span class="form-error">:message</span>') !!}
        </div>

        <div class="form-group {{ $errors->has('email' ? 'has-error' : '') }}">
            <label for="email">이메일</label>
            <input type="email" id="email" name="email" required placeholder="example@example.com">
            {!! $errors->first('email', '<span class="form-error">:message</span>') !!}
        </div>

        <div class="form-group {{ $errors->has('phone' ? 'has-error' : '') }}">
            <label for="phone">전화번호</label>
            <input type="tel" id="phone" name="phone" placeholder="'-'없이 입력: 01012345678" required>
            {!! $errors->first('phone', '<span class="form-error">:message</span>') !!}
        </div>

        <div><input type="submit" value="회원가입"></div>
    </form>
@endsection
@section('body.out')
    <script language="JavaScript">
        /**
         * 함수명:                         x
         * 함수 설명:                      사용자가 입력한 학번의 사용 가능 여부를 조회
         * 만든날:                         2018년 3월 23일
         *
         * 매개변수 목록
         * null
         *
         * 지역변수 목록
         * requestObj(Object):
         *              AJAX 통신에 사용하는 객체. 웹 브라우저에 따라 다르게 할당된다.
         * url(string):
         *              메시지를 전송하는 도착지
         * sendMessage(string):
         *              송신 메시지
         * inputStdId(Element):
         *              학번 입력 INPUT Element
         *
         * 반환값
         * null
         */
        document.getElementById('std_id_check').addEventListener('click', function() {
            // 01. 웹 브라우저에 따른 AJAX 객체 할당
            let requestObj  = null;
            let url         = '{{ route('student.check') }}';
            let sendMessage = '';
            let inputStdId  = document.getElementById('std_id');
            let inputName   = document.getElementById('name');
            if(window.XMLHttpRequest) {
                requestObj = new XMLHttpRequest();
            } else if(window.ActiveXObject) {
                requestObj = new ActiveXObject("Microsoft.XMLHTTP");
            }

            // 02. 함수 설정
            requestObj.onreadystatechange = function() {
                if(requestObj.readyState === 4 && requestObj.status === 200) {
                    let message = JSON.parse(requestObj.responseText)['msg'];

                    if(message === 'EXISTS') {
                        alert('이미 가입된 학번입니다.');
                        inputStdId.value = '';
                        inputName.value = '';
                    } else if (message === 'FALSE') {
                        alert('잘못된 입력입니다.');
                        inputStdId.value = '';
                        inputName.value = '';
                    } else if(message === '') {

                    } else {
                        inputStdId.setAttribute('readonly', 'readonly');
                        inputName.value = message;
                    }
                } else {

                }
            };

            // 03. 송신문 정의
            let std_id = inputStdId.value;
            sendMessage += '_token={{ csrf_token() }}';
            sendMessage += `&std_id=${std_id}`;

            // 04. 송신
            requestObj.open('POST', url);
            requestObj.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            requestObj.send(sendMessage);
        });
    </script>
@endsection