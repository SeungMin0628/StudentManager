<?php
/**
 * 페이지 설명: <지도교수> 내 학생 상세정보 확인 페이지 - 마스터 레이아웃
 * User: Seungmin Lee
 * Date: 2018-04-14
 * Time: 오후 6:53
 */
?>
@extends('layouts.master')
@section('body.section')
    <!-- 최상위 DIV -->
    <div>
        <!-- 좌측 인터페이스 : 타이틀, 학생 정보, 각 기능별 접속 버튼 -->
        <div>
            <div>학생 정보</div>
            <div>
                @if(strlen($student_info['face_photo']) > 0)
                    {{ Html::image('source/std_face/'.$student_info['face_photo'], 'student', ['width' => 100, 'height' => 100]) }}
                @else
                    {{ Html::image('source/std_face/dummy.jpg', 'default', ['width' => 100, 'height' => 100]) }}
                @endif
            </div>
            <div>{{ $student_info['id'] }}</div>
            <div>{{ $student_info['name'] }}</div>
            <div><a href="{{ route('tutor.details.attendance', ['std_id' => $student_info['id']]) }}">출결</a></div>
            <div><a href="{{ route('tutor.details.scores', ['std_id' => $student_info['id']]) }}">성적</a></div>
            <div><span>코멘트</span></div>
        </div>
        <div>
            @yield('details.section')
        </div>
    </div>
@endsection