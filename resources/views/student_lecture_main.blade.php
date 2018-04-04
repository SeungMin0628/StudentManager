<?php
/**
 * Created by PhpStorm.
 * 페이지 설명: <학생> 학업관리 메인 페이지
 * User: Seungmin Lee
 * Date: 2018-04-02
 * Time: 오후 6:47
 */

use App\Http\DbInfoEnum;
?>
@extends('layouts.student_master')
@section('body.section')
    <div>
        <span>@lang('lecture.title')</span>
        <span>
            <input type="button" value="@lang('pagination.previous')"
                   onclick="location.assign('{{ route('student.lecture.main', $prev_term) }}')">
            <span>@lang('lecture.term', ['year' => $year, 'term' => $term])</span>
            @if(!is_null($next_term))
                <input type="button" value="@lang('pagination.next')"
                       onclick="location.assign('{{ route('student.lecture.main', $next_term) }}')">
            @endif
        </span>
    </div>
    <div style="overflow-y: auto; height: 600px;">
        @forelse($lecture_list as $lecture)
            <div>
                <span>
                    <div>이미지</div>
                    <div>@lang('lecture.subject_name'): {{ $lecture['title'] }}</div>
                </span>
                <span>
                    <table border="1">
                        <tr>
                            <td></td>
                            <td>@lang('lecture.count')</td>
                            <td>@lang('lecture.gettable_score')</td>
                            <td>@lang('lecture.gained_score')</td>
                            <td>@lang('lecture.average')</td>
                            <td>@lang('lecture.reflection')</td>
                        </tr>
                        @foreach($lecture['score'] as $gainedScore)
                            <tr>
                                <td>{{ $gainedScore['type'] }}</td>
                                <td>{{ $gainedScore['count'] }}</td>
                                <td>{{ $gainedScore['perfect_score'] }}</td>
                                <td>{{ $gainedScore['gained_score'] }}</td>
                                <td>{{ $gainedScore['average'] }}</td>
                                <td>{{ $gainedScore['reflection'] }}%</td>
                            </tr>
                        @endforeach
                    </table>
                </span>
            </div>
            <div>
                @lang('lecture.achievement'): {{ $lecture['achievement'] }}%
            </div>
            <div>
                <input type="button" value="@lang('interface.details')"
                       onclick="location.assign('{{ route('student.lecture.details', $lecture['lecture_id']) }}')">
            </div>
            <hr>
        @empty
            <span>@lang('lecture.not_exists_lecture')</span>
        @endforelse
    </div>
@endsection
