<?php
/**
 * 페이지 설명: <교과목 교수> 성적정보 페이지
 * User: Seungmin Lee
 * Date: 2018-04-06
 * Time: 오후 8:14
 */
?>
@extends('layouts.professor_details_master')
@section('professor.my_student.details')
    {{-- 조회된 성적 리스트가 있을 경우 -> 테이블로 출력 --}}
    @if(sizeof($scores_list->all()) > 0)
        <!-- 보조 제목 -->
        <div>@lang('lecture.select')</div>
        <hr>
        <table border="1">
            {{-- 테이블 머릿글: 각 항목별 제목 --}}
            <thead>
                <tr>
                    <th>@lang('interface.date')</th>
                    <th>@lang('lecture.type')</th>
                    <th>@lang('interface.details')</th>
                    <th>@lang('lecture.gained_score') / @lang('lecture.gettable_score')</th>
                </tr>
            </thead>
            {{-- 테이블 본문: 성적 데이터 출력 --}}
            <tbody>
                @foreach($scores_list->all() as $score)
                    <tr>
                        <td>{{ $score['reg_date'] }}</td>
                        <td>{{ $score['type'] }}</td>
                        <td>{{ $score['content'] }}</td>
                        <td>{{ $score['score'].'/'.$score['perfect_score'] }}</td>
                    </tr>
                @endforeach
            </tbody>
            {{-- 테이블 꼬릿글: 페이지네이션 (2개 이상의 페이지가 존재할 경우 실행) --}}
            @if($scores_list->count() > 0)
            <tfoot>
                <tr>
                    <td colspan="4">
                        {{-- 이전 페이지 링크: 이전 페이지가 존재하면 실행 --}}
                        @if(strlen($scores_list->previousPageUrl()) > 0)
                            <input type="button" value="@lang('pagination.previous')"
                                onclick="location.assign('{{ $scores_list->previousPageUrl() }}')">
                        @endif

                        {{-- 각 페이지 링크: 현재 페이지를 가리킬 경우 비활성화--}}
                        @for($iCount = 1; $iCount <= $scores_list->lastPage(); $iCount++)
                            <input type="button" value="{{ $iCount }}"
                                   @if($iCount == $scores_list->currentPage())
                                       disabled
                                   @else
                                       onclick="location.assign('{{ $scores_list->url($iCount) }}')"
                                   @endif
                                >
                        @endfor

                        {{-- 다음 페이지 링크: 다음 페이지가 존재하면 실행 --}}
                        @if(strlen($scores_list->nextPageUrl()) > 0)
                            <input type="button" value="@lang('pagination.next')"
                                   onclick="location.assign('{{ $scores_list->nextPageUrl() }}')">
                        @endif
                    </td>
                </tr>
            </tfoot>
            @endif
        </table>
        @else
            <span>@lang('exception.not_exists_scores_data')</span>
        @endif
@endsection