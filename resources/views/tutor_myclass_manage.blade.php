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
        <!-- 조회 학기 설정 -->
        <span>
            <input type="button" value="@lang('pagination.previous')"
                   {{-- onclick="location.assign('{{ $이전학기 }}')" --}}>
            <span>2018년도 1학기</span>
            <input type="button" value="@lang('pagination.next')"
                   {{-- onclick="location.assign('{{ $다음학기 }}')" --}}>
        </span>
        <!-- 정렬 기준 설정 -->
        <span>
            @lang('interface.order_by'):
            <input type="button" value="@lang('account.std_id')"
                   {{-- onclick="location.assign('{{ $학번 }}')" --}}>
            <input type="button" value="@lang('account.name')"
                   {{-- onclick="location.assign('{{ $이름 }}')" --}}>
        </span>
    </div>
    <!-- 조회된 데이터 리스트 출력 -->
    <div>
        {{--@if(!is_null($학생리스트))--}}
        {{--
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
                @foreach($학생목록 as $학생)
                    <tr>
                        <td>{{ $학생->학번 }}</td>
                        <td>{{ $학생->이름 }}</td>
                        <td>{{ $학생->학업성취도 }}</td>
                        <td>
                            <a href="{{ route('') }}" target="_blank">@lang('lecture.select')</a>
                            <a href="{{ route('') }}" target="_blank">@lang('interface.comment')</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4">
                        페이지네이션
                    </td>
                </tr>
            </tfoot>
        </table>
        --}}
        {{--@else--}}
        {{--
        <span>조회된 학생이 없습니다.</span>
        --}}
        {{--@endif--}}
    </div>
@endsection