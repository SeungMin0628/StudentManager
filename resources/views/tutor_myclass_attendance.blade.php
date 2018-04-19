<?php
/**
 * 페이지 설명: <지도교수> 오늘 등/하교 기록 표시
 * User: Seungmin Lee
 * Date: 2018-04-15
 * Time: 오후 9:24
 */
?>
@extends('layouts.tutor_master')
@section('style')
    <style type="text/css">
        div .student_element {
            border: 1px solid black;
            width:  200px;
            font-weight: bold;
        }

        div .late {
            background-color: yellow;
        }

        div .absence {
            background-color: darkred;
            color:            white;
        }

        div .good {
            background-color: royalblue;
        }
    </style>
@endsection
@section('body.section')
    <h2>등・하교 출결</h2>

    <hr>
    <!-- 출결 기록을 출력하는 리스트 -->
    <div>
        <table border="1">
        <!-- 머릿글 : 제목 행 -->
            <thead>
                <tr>
                    <th>등교</th>
                    <th>하교</th>
                    <th>결석</th>
                    <th>지각</th>
                    <th>관심학생</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <!-- 등교 학생 -->
                    <td>
                        @forelse($attendance_data as $student)
                            <div class="student_element good"
                                 onclick="location.assign('{{ route('tutor.details.attendance', ['std_id' => $student['id']]) }}')">
                                <div>학번:{{$student['id']}}</div>
                                <div>이름: {{$student['name']}}</div>
                                <div>등교시각: {{$student['come']}}</div>
                            </div>
                        @empty
                            조회된 데이터가 없습니다.
                        @endforelse
                    </td>
                    <!-- 하교 학생 -->
                    <td>
                        @forelse($leave_data as $student)
                            <div class="student_element
                                @if($student['late_flag'])
                                    late
                                @endif" onclick="location.assign('{{ route('tutor.details.attendance', ['std_id' => $student['id']]) }}')">
                                <div>학번:{{$student['id']}}</div>
                                <div>이름: {{$student['name']}}</div>
                                <div>하교시각: {{$student['leave']}}</div>
                            </div>
                        @empty
                            조회된 데이터가 없습니다.
                        @endforelse
                    </td>
                    <!-- 결석 학생 -->
                    <td>
                        @forelse($absence_data as $student)
                            <div class="student_element absence"
                                    onclick="location.assign('{{ route('tutor.details.attendance', ['std_id' => $student['id']]) }}')">
                                <div>학번:{{$student['id']}}</div>
                                <div>이름: {{$student['name']}}</div>
                            </div>
                        @empty
                            조회된 데이터가 없습니다.
                        @endforelse
                    </td>
                    <!-- 지각 학생 -->
                    <td>
                        @forelse($late_data as $student)
                            <div class="student_element late"
                                 onclick="location.assign('{{ route('tutor.details.attendance', ['std_id' => $student['id']]) }}')">
                                <div>학번:{{$student['id']}}</div>
                                <div>이름: {{$student['name']}}</div>
                                <div>등교시각: {{$student['come']}}</div>
                            </div>
                        @empty
                            조회된 데이터가 없습니다.
                        @endforelse
                    </td>
                    <!-- 관심학생 -->
                    <td>
                        @forelse($care_data as $student)
                            <div class="student_element
                                @if($student['late_flag'])
                                    late
                                @elseif($student['absence_flag'])
                                    absence
                                @endif
                                 " onclick="location.assign('{{ route('tutor.details.attendance', ['std_id' => $student['id']]) }}')">
                                <div>학번:{{$student['id']}}</div>
                                <div>이름: {{$student['name']}}</div>
                                <div>등교시각: {{ $student['come'] }}</div>
                                <div>사유: {{$student['reason']}}</div>
                            </div>
                        @empty
                            조회된 데이터가 없습니다.
                        @endforelse
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div>
    </div>
@endsection
