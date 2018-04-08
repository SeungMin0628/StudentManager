<?php
/**
 * 페이지 설명: <교과목 교수> 출석체크 실행 페이지
 * User: Seungmin Lee
 * Date: 2018-04-06
 * Time: 오후 5:42
 */
?>
@extends('layouts.professor_master')
@section('body.section')
    <div>
    {{-- 내 수강반의 학생 목록을 출력 --}}
    @if(!is_null($studentList))
        <span style="height: 800px; overflow-y: auto;">
            <table border="1">
                <head>
                    <tr>
                        <th>@lang('account.std_id')</th>
                        <th>@lang('account.name')</th>
                        <th></th>
                    </tr>
                </head>
                <tbody>
                    @foreach($studentList as $student)
                    <tr>
                        <td>{{ $student->id }}</td>
                        <td>{{ $student->name }}</td>
                        <td>
                            <a href="{{ route('professor.details.scores', $student->id) }}" target="_blank">@lang('interface.details')</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </span>
        <span>
            <input type="button" value="@lang('interface.check_attendance')">
            <div>
                @lang('interface.now_time'): <span>4월 8일 11:55:48</span>
            </div>
            <div>
                @lang('interface.process_time'): <input type="text" maxlength="1" size="1">@lang('interface.minute')
            </div>
            <div>
                @lang('interface.total_people'): 0/{{ sizeof($studentList) }}
            </div>
        </span>
        @else
            <span>현재 정보 없음</span>
        @endif
    </div>
@endsection