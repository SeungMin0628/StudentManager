<?php
/**
 * 페이지 설명: <지도교수> 학생별 코멘트 확인 페이지
 * User: Seungmin Lee
 * Date: 2018-04-13
 * Time: 오전 2:11
 */
?>
@extends('layouts.tutor_master')
@section('body.section')
    <!-- 알림 추가 -->
    <div>
        <h2>알림 추가</h2>
        <span>
            <form action="{{ route('tutor.myclass.needcare.store') }}" method="post">
                {{ csrf_field() }}
                <label>
                    <select name="days_unit">
                        <option value="week">일주일</option>
                        <option value="month">한 달</option>
                        <option value="input">직접 설정</option>
                    </select>
                </label>
                동안
                <label>
                    <select name="attendance_type">
                        <option value="late">지각</option>
                        <option value="absence">결석</option>
                        <option value="early">조퇴</option>
                    </select>
                </label>
                을
                <label>
                    <select name="continuity_flag">
                        <option value="true">연속</option>
                        <option value="false">누적</option>
                    </select>
                </label>
                <input type="number" name="count" min="1" max="99" required>
                회 이상 할 경우
                <label>
                    <select name="target">
                        <option value="tutor">나</option>
                        <option value="student">학생</option>
                        <option value="both">나와 학생</option>
                    </select>
                </label>
                에게 알림
                <input type="submit" value="추가">
            </form>
        </span>
    </div>
    <hr>
    <!-- 알림 확인 -->
    <div>
        <h2>알림 확인</h2>
        @forelse($alert_list as $alert)
            <div>
                @switch($alert->days_unit)
                    @case(7)
                        일주일
                    @break
                    @case(30)
                        한 달
                    @break
                    @default
                        {{ $alert->days_unit }}일
                    @break
                @endswitch
                동안&nbsp;
                @switch($alert->notification_flag)
                    @case(0)
                    @case(3)
                    지각
                    @break
                    @case(1)
                    @case(4)
                    조퇴
                    @break
                    @case(2)
                    @case(5)
                    결석
                    @break;
                @endswitch
                을&nbsp;
                @switch($alert->notification_flag)
                    @case(0)
                    @case(1)
                    @case(2)
                        연속 {{$alert->needed_count}}
                    @break
                    @case(3)
                    @case(4)
                    @case(5)
                        누적 {{$alert->needed_count}}
                    @break;
                @endswitch
                회 이상 할 경우&nbsp;
                @if($alert->alert_prof_flag && !$alert->alert_std_flag)
                    나
                @elseif($alert->alert_prof_flag && $alert->alert_std_flag)
                    나와 학생
                @elseif(!$alert->alert_prof_flag && $alert->alert_std_flag)
                    학생
                @endif
                에게 알림&nbsp;
            </div>
        @empty
            현재 설정이 없습니다.
        @endforelse
    </div>
@endsection
@section('script')
    <script language="JavaScript">
        $(document).ready(function() {
            // 기간 선택자 이벤트 설정 (사용자가 직접 입력을 선택하면 => 입력창 출력
            $('select[name=days_unit]').each(function () {

                $(this).change(function() {
                    if($(this).val() === 'input') {
                        $(this).parent().append(
                            $('<input type="number" min="1" max="99" name="input_days_unit" required>')
                        );
                    } else {
                        $(this).next().remove();
                    }
                });
            });
        });
    </script>
@endsection