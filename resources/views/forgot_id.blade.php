<?php
/**
 * Created by PhpStorm.
 * User: Seungmin Lee
 * Date: 2018-03-29
 * Time: 오후 3:35
 */
?>
@extends('layouts.forgot_master')
@section('body.section')
    <div>@lang('account.select_user_type')</div>
    <div>
        <label for="user_type_student">@lang('account.student')</label>
        <input type="radio" id="user_type_student" name="user_type" value="student">
        &nbsp;
        <label for="user_type_professor">@lang('account.professor')</label>
        <input type="radio" id="user_type_professor" name="user_type" value="professor">
    </div>
@endsection
@section('script')
    <script language="JavaScript">
        $(document).ready(function() {
            /**
             *  함수명:                    checkRadioButtons
             *  함수 설명:                 사용자가 라디오 버튼을 체크했는지 여부 확인
             *  만든 날:                   2018-03-29
             *
             *  지역변수 목록
             *  radioButtons:              라디오 버튼 목록
             *
             *  매개변수 목록
             *  null
             *
             *  @returns {boolean}
             */
            function checkRadioButtons() {
                // 01. 변수 할당
                let radioButtons = $("input[name=user_type]");

                for(let radioButton of radioButtons) {
                    if(radioButton.checked) {
                        return radioButton.value;
                    }
                }

                return false;
            }


            // 아이디 찾기 버튼 & 비밀번호 찾기 버튼 OnClick EventListener 부착
            //      => 회원 유형과 찾는 정보에 따른 링크 변환
            $("#button_search_id").click(function() {

                }
            );

            $('#button_search_password').click(function() {

            });
        });
    </script>
@endsection
