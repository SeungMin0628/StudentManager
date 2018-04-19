<?php
/**
 * 페이지 설명: <지도교수> 내 학생 상세 정보 확인 페이지 - 출결 정보
 * User: Seungmin Lee
 * Date: 2018-04-14
 * Time: 오후 7:03
 */
?>
@extends('layouts.tutor_details_master')
@section('details.section')
    <!-- 상단 인터페이스 => 등/하교 출결, 분석  -->
    <div>
        <b>등/하교 출결</b>
        <span>출결 분석</span>
    </div>
    <hr>
    <!-- 하단 인터페이스 => 출결 그래프, 상세 -->
    <div>
        <!-- 출결 그래프 -->
        <div>
            <h3>출결 그래프</h3>
            <!-- 조회 기간 선택 -->
            <div>
                <!-- 연 단위 조회 버튼 -->
                <input type="button" value="연간"
                       onclick="location.assign('{{ route('tutor.details.attendance',
                            ['std_id' => $student_info['id'], 'period' => 'yearly']) }}')">

                <!-- 월 단위 조회 버튼 -->
                <input type="button" value="월간"
                       onclick="location.assign('{{ route('tutor.details.attendance',
                            ['std_id' => $student_info['id'], 'period' => 'monthly']) }}')">

                <!-- 주 단위 조회 버튼 -->
                <input type="button" value="주간"
                       onclick="location.assign('{{ route('tutor.details.attendance',
                            ['std_id' => $student_info['id'], 'period' => 'weekly']) }}')">

                <!-- 이전일자 조회 버튼 -->
                <input type="button" value="@lang('pagination.previous')"
                       onclick="location.assign('{{ route('tutor.details.attendance',
                            ['stdId' => $student_info['id'], 'period' => $period, 'date' => $date_info['prev']]) }}')">

                <!-- 현재 조회일자 표시 -->
                <span>{{ $date_info['this'] }}</span>

                <!-- 다음일자 조회 버튼 -->
                @if(!is_null($date_info['next']))
                    <input type="button" value="@lang('pagination.next')"
                       onclick="location.assign('{{ route('tutor.details.attendance',
                           ['stdId' => $student_info['id'], 'period' => $period, 'date' => $date_info['next']]) }}')">
                @endif
            </div>
            <!-- 그래프 자리 -->
            <div>
                <div>출석: {{ $recently_attendance['attendance'] }}</div>
                <div>지각: {{ $recently_attendance['late'] }}</div>
                <div>결석: {{ $recently_attendance['absence'] }}</div>
                <div>조퇴: {{ $recently_attendance['early'] }}</div>
            </div>
        </div>
        <!-- 상세 정보 -->
        <div>
            <h3>상세</h3>
            <!-- 출결 정보  -->
            <table border="1">
                <!-- 총 *** 횟수 -->
                <tr>
                    <th>총 출석횟수</th>
                    <td>{{ $attendance_analyze['total_ada'] }}</td>
                    <th>총 지각횟수</th>
                    <td>{{ $attendance_analyze['total_late'] }}</td>
                    <th>총 결석횟수</th>
                    <td>{{ $attendance_analyze['total_absence'] }}</td>
                    <th>총 조퇴횟수</th>
                    <td>{{ $attendance_analyze['total_early'] }}</td>
                </tr>
                <!-- 최근 등교 시각, 연속 *** 횟수 -->
                <tr>
                    <th>최근 등교시각</th>
                    <td>{{ $attendance_analyze['recent_come'] }}</td>
                    <th>연속 지각횟수</th>
                    <td>{{ $attendance_analyze['consecutive_late'] }}</td>
                    <th>연속 결석횟수</th>
                    <td>{{ $attendance_analyze['consecutive_absence'] }}</td>
                    <th>연속 조퇴횟수</th>
                    <td>{{ $attendance_analyze['consecutive_early'] }}</td>
                </tr>
                <!-- 최근 하교시각, 등교시각, 하교시각, 비고 -->
                <tr>
                    <th>최근 하교시각</th>
                    <td>
                        @if(is_null( $attendance_analyze['recent_leave'] ))
                            학습 중
                        @else
                            {{ $attendance_analyze['recent_leave'] }}
                        @endif
                    </td>
                    <th>최근 지각일자</th>
                    <td>
                        @if(!is_null($attendance_analyze['recent_late']))
                            {{ $attendance_analyze['recent_late'] }}
                        @else
                            기록 없음
                        @endif
                    </td>
                    <th>최근 결석일자</th>
                    <td>
                        @if(!is_null($attendance_analyze['recent_absence']))
                            {{ $attendance_analyze['recent_absence'] }}
                        @else
                            기록 없음
                        @endif
                    </td>
                    <th>최근 조퇴일자</th>
                    <td>
                        @if(!is_null($attendance_analyze['recent_early']))
                            {{ $attendance_analyze['recent_early'] }}
                        @else
                            기록 없음
                        @endif
                    </td>
                </tr>
            </table>
            <!-- -->
            <table border="1">
                <!-- 테이블 머릿글: 각 항목의 제목 -->
                <thead>
                    <tr>
                        <th>일자</th>
                        <th>등교시각</th>
                        <th>하교시각</th>
                        <th>비고</th>
                    </tr>
                </thead>
                <!-- 테이블 본문: 지도학생 등하교 출결 전체내역 보기-->
                <tbody>
                    {{-- 조회 데이터를 반복문으로 출력 --}}
                    @forelse($attendance_records->all() as $attendance_record)
                        <tr>
                            <td>{{ $attendance_record['reg_date'] }}</td>
                            <td>{{ $attendance_record['come'] }}</td>
                            <td>
                                @if(!is_null($attendance_record['leave']))
                                    {{ $attendance_record['leave'] }}
                                @else
                                    기록 없음
                                @endif
                            </td>
                            <td>
                                @if($attendance_record['late'])<span>지각</span>@endif
                                @if($attendance_record['early'])<span>조퇴</span>@endif
                                @if($attendance_record['absence'])<span>결석</span>@endif
                            </td>
                        </tr>
                    @empty
                        {{-- 조회된 데이터가 없을 경우 --}}
                        <tr>
                            <td colspan="4">
                                조회된 데이터가 없습니다.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                <!-- 테이블 꼬릿글: 페이지네이션 -->
                <tfoot>
                    <tr><td colspan="4">
                    {{-- 이전 페이지 링크: 이전 페이지가 존재하면 실행 --}}
                    @if(strlen($attendance_records->previousPageUrl()) > 0)
                        <input type="button" value="@lang('pagination.previous')"
                               onclick="location.assign('{{ $attendance_records->previousPageUrl() }}')">
                    @endif

                    {{-- 각 페이지 링크: 현재 페이지를 가리킬 경우 비활성화--}}
                    @for($iCount = 1; $iCount <= $attendance_records->lastPage(); $iCount++)
                        <input type="button" value="{{ $iCount }}"
                                @if($iCount == $attendance_records->currentPage())
                                disabled style="font-weight: bold"
                                @else
                                onclick="location.assign('{{ $attendance_records->url($iCount) }}')"
                                @endif
                        >
                    @endfor

                    {{-- 다음 페이지 링크: 다음 페이지가 존재하면 실행 --}}
                    @if(strlen($attendance_records->nextPageUrl()) > 0)
                        <input type="button" value="@lang('pagination.next')"
                               onclick="location.assign('{{ $attendance_records->nextPageUrl() }}')">
                    @endif
                    </td></tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
