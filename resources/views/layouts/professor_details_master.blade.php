<?php
/**
 * 페이지 설명: <교과목교수> 내 수강반의 학생에 대한 상세정보 레이아웃
 * User: Seungmin Lee
 * Date: 2018-04-06
 * Time: 오후 7:34
 */
?>
@extends('layouts.master')
@section('body.section')
    {{-- 전체 틀 --}}
    <div>
        {{--
            좌측 인터페이스
            : 타이틀, 학생 사진, 버튼
         --}}
        <div>
            <div>@lang('interface.student_info')</div>
            <div>
            @if(strlen($student_info['face_photo']) > 0)
                {{ Html::image('source/std_face/'.$student_info['face_photo'], 'student', ['width' => 100, 'height' => 100]) }}
            @else
                {{ Html::image('source/std_face/dummy.jpg', 'default', ['width' => 100, 'height' => 100]) }}
            @endif
            </div>
            <div>
                <a href="{{ route('professor.details.scores', ['stdId' => $student_info['id']]) }}">
                    @lang('interface.score')</a>
            </div>
            <div>
                <a href="{{ route('professor.details.comments', ['stdId' => $student_info['id']]) }}">
                    @lang("interface.comment")</a>
            </div>
        </div>
        {{--
            우측 인터페이스
            : 상담 페이지 or 코멘트 페이지
        --}}
        <div>
            @yield('professor.my_student.details')
        </div>
    </div>
@endsection