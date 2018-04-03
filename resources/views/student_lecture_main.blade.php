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
            <input type="button" value="@lang('pagination.previous')">
            <span>2018년 1학기</span>
            <input type="button" value="@lang('pagination.next')">
        </span>
    </div>
    <div style="overflow-y: auto; height: 600px;">
        @forelse($lecture_list as $lecture)
            <div>
                <span>
                    <div>이미지</div>
                    <div>과목명: {{ $lecture['title'] }}</div>
                </span>
                <span>
                    <table border="1">
                        <tr>
                            <td></td>
                            <td>횟수</td>
                            <td>취득가능점수</td>
                            <td>취득점수</td>
                            <td>평균</td>
                            <td>반영비율</td>
                        </tr>
                        @foreach($lecture['score'] as $gainedScore)
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endforeach
                    </table>
                </span>
            </div>
            <div>
                학업성취도: {{ $lecture['achievement'] }}%
            </div>
            <div>
                <input type="button" value="상세보기">
            </div>
            <div>
                {{ var_dump($lecture) }}
            </div>
            <hr>
        @empty
            <span>현재 수강중 과목 없음</span>
        @endforelse
    </div>
@endsection
