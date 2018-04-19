<?php
/**
 * Created by PhpStorm.
 * 페이지 설명: <학생> 출결 관리 페이지
 * User: Seungmin Lee
 * Date: 2018-03-30
 * Time: 오전 10:00
 */
?>
@extends('layouts.student_master')
@section('body.section')
    <div>
        <!-- 보조 제목 - 등/하교 출결 -->
        <div>@lang('attendance.come_leave')</div>
        <!-- 조회기간 표시 & 조정 인터페이스 -->
        <div>
            <span>
                <input type="button" id="button_prev" value="@lang('pagination.previous')">
            </span>
            <span id="date">{{ $date }}</span>
            @if(!is_null($next_date))
                <span>
                    <input type="button" id="button_next" value="@lang('pagination.next')">
                </span>
            @endif
        </div>
        <!-- 주간/월간 선택 인터페이스 -->
        <div>
            <input type="button" id="button_weekly" value="@lang('interface.weekly')"
                   @if($period == 'weekly') disabled @endif>
            <input type="button" id="button_monthly" value="@lang('interface.monthly')"
                   @if($period == 'monthly') disabled @endif>
        </div>
    </div>
    @if(!is_null($attendance_data))
    <div>
        <!-- 출석률 표시 -->
        <div>
            <span>@lang('attendance.attendance_rate')</span>
           {{-- <span>{{ $attendance_rate }}%</span>--}}
        </div>

        <!-- 간략한 출석 기록 표시 -->
        <div>
            <span>@lang('attendance.attendance'): {{ $attendance_data['attendance'] }}</span>
            <span>@lang('attendance.late'): {{ $attendance_data['late'] }}</span>
            <span>@lang('attendance.absence'): {{ $attendance_data['absence'] }}</span>
            <span>@lang('attendance.early'): {{ $attendance_data['early'] }}</span>
        </div>
    </div>
    <div>
        <!-- 상세 출석 기록 표시 -->
        <table border="1">
            <th colspan="8">@lang('interface.details')</th>
            <tr>
                <td>@lang('attendance.attendance')</td><td>{{ $attendance_data['attendance'] }}</td>
                <td>@lang('attendance.late')</td><td>{{ $attendance_data['late'] }}</td>
                <td>@lang('attendance.absence')</td><td>{{ $attendance_data['absence'] }}</td>
                <td>@lang('attendance.early')</td><td>{{ $attendance_data['early'] }}</td>
            </tr>
            <tr>
                <td>@lang('attendance.nearest_attendance')</td><td>{{ $attendance_data['nearest_attendance']  }}</td>
                <td>@lang('attendance.nearest_late')</td><td>{{ $attendance_data['nearest_late']  }}</td>
                <td>@lang('attendance.nearest_absence')</td><td>{{ $attendance_data['nearest_absence']  }}</td>
                <td>@lang('attendance.nearest_early')</td><td>{{ $attendance_data['nearest_early']  }}</td>
            </tr>
        </table>
    </div>
    @else
        <div>현재 존재하는 데이터가 없습니다.</div>
    @endif
@endsection
@section('script')
    <script language="JavaScript">
        // 기간 변경 이벤트
        function changePeriod(event) {
            let period = '';
            if(event.target.id === 'button_weekly') {
                period = 'weekly';
            } else if (event.target.id === 'button_monthly') {
                period = 'monthly';
            }
            location.replace('{{route('student.attendance')}}/' + period);
        }

        $('#button_weekly').click(changePeriod);
        $('#button_monthly').click(changePeriod);

        // 이전 기간 조회 이벤트 설정
        $('#button_prev').click(function() {
            location.replace('{{route('student.attendance')}}/' + getPeriod() + '/{{$prev_date}}');
        });

        // 다음 기간 조회 이벤트 설정
        $('#button_next').click(function() {
            location.replace('{{route('student.attendance')}}/' + getPeriod() + '/{{$next_date}}');
        });

        // 현재 일자 출력 양식 획득
        function getPeriod() {
            let nowDate = $('#date').text();
            if (nowDate.split('-').length > 2) {
                return 'weekly';
            } else {
                return 'monthly';
            }
        }
    </script>
@endsection