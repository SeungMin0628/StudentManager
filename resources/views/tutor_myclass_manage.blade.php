<?php
/**
 * 페이지 설명: <지도교수> 내 지도반 관리
 * User: Seungmin Lee
 * Date: 2018-04-01
 * Time: 오후 9:38
 */
?>
@extends('layouts.tutor_master')
@section('body.section')
    <h2>@lang('myclass.manage_student')</h2>
    <!-- 조회 기준 설정 : 학기, 정렬 기준 -->
    <div>
        <!-- 정렬 기준 설정 -->
        <span>
            @lang('interface.order_by'):
            <input type="button" value="@lang('account.std_id')"
                    @if($order != 'std_id')
                    onclick="location.assign('{{ route('tutor.myclass.manage', ['order' => 'id']) }}')"
                    @endif>
            <input type="button" value="@lang('account.name')"
                    @if($order != 'name')
                    onclick="location.assign('{{ route('tutor.myclass.manage', ['order' => 'name']) }}')">
                    @endif
        </span>
    </div>
    <!-- 조회된 데이터 리스트 출력 -->
    <div>
        @if(is_array($student_list->all()))
        <table>
            <thead>
                <tr>
                    <th>@lang('account.std_id')</th>
                    <th>@lang('account.name')</th>
                    <th>@lang('lecture.achievement')</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($student_list->all() as $student)
                    <tr>
                        <td>{{ $student->id }}</td>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->achievement }}%</td>
                        <td>
                            <a href="{{ route('tutor.details.attendance', ['stdId' => $student->id]) }}" target="_blank">@lang('lecture.select')</a>
                            <a href="{{-- route('') --}}" target="_blank">@lang('interface.comment')</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4">
                        {{-- 이전 페이지 링크: 이전 페이지가 존재하면 실행 --}}
                        @if(strlen($student_list->previousPageUrl()) > 0)
                            <input type="button" value="@lang('pagination.previous')"
                                   onclick="location.assign('{{ $student_list->previousPageUrl() }}')">
                        @endif

                        {{-- 각 페이지 링크: 현재 페이지를 가리킬 경우 비활성화--}}
                        @for($iCount = 1; $iCount <= $student_list->lastPage(); $iCount++)
                            <input type="button" value="{{ $iCount }}"
                                   @if($iCount == $student_list->currentPage())
                                   disabled
                                   @else
                                   onclick="location.assign('{{ $student_list->url($iCount) }}')"
                                    @endif
                            >
                        @endfor

                        {{-- 다음 페이지 링크: 다음 페이지가 존재하면 실행 --}}
                        @if(strlen($student_list->nextPageUrl()) > 0)
                            <input type="button" value="@lang('pagination.next')"
                                   onclick="location.assign('{{ $student_list->nextPageUrl() }}')">
                        @endif
                    </td>
                </tr>
            </tfoot>
        </table>
        @else
        <span>조회된 학생이 없습니다.</span>
        @endif
    </div>
@endsection