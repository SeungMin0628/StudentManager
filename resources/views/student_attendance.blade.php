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
        <div>@lang('attendance.come_leave')</div>
        <div>
            <span><a href="">@lang('pagination.previous')</a></span>
            <span>{{ $date }}</span>
            @if(!is_null($next_date))
                <span><a href="">@lang('pagination.next')</a></span>
            @endif
        </div>
        <div>
            <input type="button" id="button_weekly" value="@lang('interface.weekly')"
                   @if($period == 'weekly') disabled @endif>
            <input type="button" id="button_monthly" value="@lang('interface.monthly')"
                   @if($period == 'monthly') disabled @endif>
        </div>
    </div>
    <div>
        <span>
            <div>@lang('attendance.attendance_rate')</div>
            <div>{{ $attendance_rate }}%</div>
        </span>
        <span>
            <span>@lang('attendance.attendance'): {{ $attendance }}</span>
            <span>@lang('attendance.late'): {{ $late }}</span>
            <span>@lang('attendance.absence'): {{ $absence }}</span>
            <span>@lang('attendance.early'): {{ $early }}</span>
        </span>
    </div>
    <div>
        <table border="1">
            <th colspan="8">@lang('interface.details')</th>
            <tr>
                <td>@lang('attendance.attendance')</td><td>{{ $attendance }}</td>
                <td>@lang('attendance.late')</td><td>{{ $late }}</td>
                <td>@lang('attendance.absence')</td><td>{{ $absence }}</td>
                <td>@lang('attendance.early')</td><td>{{ $early }}</td>
            </tr>
            <tr>
                <td>@lang('attendance.nearest_attendance')</td><td>{{ $nearest_attendance }}</td>
                <td>@lang('attendance.nearest_late')</td><td>{{ $nearest_late }}</td>
                <td>@lang('attendance.nearest_absence')</td><td>{{ $nearest_absence }}</td>
                <td>@lang('attendance.nearest_early')</td><td>{{ $nearest_early }}</td>
            </tr>
        </table>
    </div>
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
    </script>
@endsection