<?php
/**
 * 페이지 설명: <교과목 교수> 해당 학생에 대한 코멘트 관리
 * User: Seungmin Lee
 * Date: 2018-04-06
 * Time: 오후 9:48
 */
?>
@extends('layouts.professor_details_master')
@section('professor.my_student.details')
    <!-- 보조 제목 -->
    <div>@lang('interface.comment')</div>
    <hr>
    {{-- 코멘트 출력 영역 --}}
    <div>
        {{-- 학기 조회 --}}
        <div>
            <input type="button" value="@lang('pagination.previous')"
                onclick="location.assign('{{ route('professor.details.comments', ['stdId' => $student_info['id'], 'term' => $term['prev_term']]) }}')">
            @lang('lecture.term', ['year' => $term['year'], 'term' => $term['term']])
            @if(!is_null($term['next_term']))
            <input type="button" value="@lang('pagination.next')"
                onclick="location.assign('{{ route('professor.details.comments', ['stdId' => $student_info['id'], 'term' => $term['next_term']]) }}')">
            @endif
        </div>
        {{-- 코멘트 영역 --}}
        {{--
            @if(!is_null($코멘트_목록))
                <table border='1'>
                    <tbody>
                        @foreach($코멘트_목록 as $코멘트)
                        <tr>
                            <td>$코멘트->교수님</td>
                            <td>$코멘트->내용</td>
                            <td>
                                <input 답글 달기 버튼>
                                @if($코멘트->작성자인지? == TRUE)
                                <input 수정 버튼>
                                <input 삭제 버튼>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div>현재 등록된 코멘트가 없습니다.</div>
            @endif
        --}}
    </div>
    <hr>
    {{-- 내 코멘트 입력창 --}}
    <div>{{  $professor_name }}</div>
    <textarea>
    </textarea>
    <input type="button" value="@lang('interface.submit')">
@endsection