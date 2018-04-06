<?php
/**
 * 페이지 설명: <학생> 학업관리 페이지
 * User: Seungmin Lee
 * Date: 2018-04-02
 * Time: 오후 6:47
 */
?>
@extends('layouts.student_master')
@section('body.section')
    <div>
        <span>@lang('lecture.title')</span>
        <span>
            <input type="button" value="@lang('pagination.previous')"
                   onclick="location.assign('{{ route('student.lecture', $prev_term) }}')">
            <span>@lang('lecture.term', ['year' => $year, 'term' => $term])</span>
            @if(!is_null($next_term))
                <input type="button" value="@lang('pagination.next')"
                       onclick="location.assign('{{ route('student.lecture', $next_term) }}')">
            @endif
        </span>
    </div>
    <div style="overflow-y: auto; height: 600px;">
        @forelse($lecture_list as $lecture)
            <div>
                <span>
                    @if(strlen($lecture['prof_info']->face_photo) > 0)
                        <div>{{ Html::image('source/prof_face/'.$lecture['prof_info']->face_photo, 'professor',
                                    ['width' => 100, 'height' => 100]) }}</div>
                    @else
                        <div>{{ Html::image('source/prof_face/default.png', 'default',
                                    [ 'width' => 100, 'height' => 100]) }}</div>
                    @endif
                    <div>{{ $lecture['prof_info']->name }}</div>
                </span>
                <span>
                    <div>@lang('lecture.subject_name'): {{ $lecture['title'] }}</div>
                    <table border="1">
                        <thead>
                            <tr>
                                <th></th>
                                <th>@lang('lecture.count')</th>
                                <th>@lang('lecture.gettable_score')</th>
                                <th>@lang('lecture.gained_score')</th>
                                <th>@lang('lecture.average')</th>
                                <th>@lang('lecture.reflection')</th>
                            </tr>
                        </thead>
                        <tbody>
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
                        </tbody>
                    </table>
                </span>
            </div>
            <div>
                @lang('lecture.achievement'): {{ $lecture['achievement'] }}%
            </div>
            <div>
                @if(!is_null($lecture['gained_score']))
                <table border="1">
                    <thead>
                        <tr>
                            <th>@lang('interface.date')</th>
                            <th>@lang('lecture.type')</th>
                            <th>@lang('lecture.score_content')</th>
                            <th>@lang('lecture.gained_score')/@lang('lecture.gettable_score')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lecture['gained_score'] as $gained_score)
                            <tr>
                                <td>{{ $gained_score['reg_date'] }}</td>
                                <td>{{ $gained_score['type'] }}</td>
                                <td>{{ $gained_score['content'] }}</td>
                                <td>{{ $gained_score['score'].'/'.$gained_score['perfect_score'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                    @lang('lecture.not_exists_scores')
                @endif
            </div>
            <hr>
        @empty
            <span>@lang('lecture.not_exists_lecture')</span>
        @endforelse
    </div>
@endsection
