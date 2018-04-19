<?php
/**
 * Created by PhpStorm.
 * User: Seungmin Lee
 * Date: 2018-04-12
 * Time: 오전 1:03
 */
?>
@extends('layouts.tutor_master')
@section('style')
    <style type="text/css">
        .modal_layout {
            display:none;
            position:relative;
        }

        .modal_content {
            width:440px;
            height:300px;
            padding:20px;
            border:1px solid #ccc;
            position:fixed;
            overflow-y: auto;
            z-index:11;
        }

        .modal_content button {
            position: absolute;
            top: 0;
            right: 0;
            cursor: pointer;
        }
    </style>
@endsection
@section('body.section')
    <!-- 최상위 메인 div -->
    <div>
        <!-- 좌측 인터페이스: 등록 -->
        <span>
            <div>
                <form id="import_students_excel" enctype="multipart/form-data" action="{{ route('tutor.config.store.student.excel.select') }}" method="post">
                    {!! csrf_field() !!}
                    <span>엑셀 등록</span>
                    <label for="radio_freshman">신입생</label>
                    <input type="radio" name="student_type" value="freshman" id="radio_freshman" required>
                    <label for="radio_enrolled">재학생</label>
                    <input type="radio" name="student_type" value="enrolled" id="radio_enrolled" required>
                    <label for="upload_excel">경로</label>
                    <input type="file" name="std_list" id="upload_excel" required>
                    <input type="submit" value="@lang('interface.select')">
                </form>
            </div>
            <div>
                <form action="" method="post">
                    {!! csrf_field() !!}
                    <span>직접 입력</span>
                    <label for="input_std_id">@lang('account.std_id')</label>
                    <input type="text" name="std_id" id="input_std_id" required>
                    <label for="input_name">@lang('account.name')</label>
                    <input type="text" name="name" id="input_name" required>
                    <input type="submit" value="@lang('interface.submit')">
                </form>
            </div>
        </span>
        <!-- 우측 인터페이스: 학생 목록 -->
        <span>
            <div>
                학생 목록
            </div>
        </span>
    </div>

    <!-- 모달: 엑셀로 불러온 학생 목록에서 추가할 학생을 선택 -->
    <div id="modal_import_student" class="modal_layout">
        <div class="modal_content">
            <!-- 닫기 버튼 -->
            <button>@lang('interface.close')</button>
            <!-- 불러온 학생 중에서 저장할 학생을 선택하여 전송하는 form 문 -->
            <form action="{{ route('tutor.config.store.student.excel.insert') }}" method="post" id="insert_student">
                {!! csrf_field() !!}
                <!-- 학생 목록 테이블 -->
                <table border="1">
                    <!-- 머릿글: 칼럼명, 반 전체 선택 인터페이스 -->
                    <thead>
                        <!-- 칼럼명 -->
                        <tr>
                            <th></th>
                            <th>@lang('account.std_id')</th>
                            <th>@lang('account.name')</th>
                            <th>반</th>
                            <th>유형</th>
                        </tr>
                        <!-- 반 전체 선택 -->
                        <tr>
                            <td colspan="5" id="select_class"></td>
                        </tr>
                    </thead>
                    <!-- 본문: 학생 리스트 -->
                    <tbody id="import_student_list"></tbody>
                    <!-- 꼬릿글: 페이지네이션 & 등록 버튼 -->
                    <tfoot>
                        <tr>
                            <td colspan="5" id="student_list_pagination"></td>
                        </tr>
                        <tr>
                            <td colspan="5">
                                <input type="submit" value="@lang('interface.submit')">
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script language="JavaScript">
        // 모달 이벤트 설정
        let import_student_modal = $('#modal_import_student');

        // 엑셀을 이용한 학생 정보 submit 이벤트 설정
        $('#import_students_excel').submit(function(event) {
            // 이벤트 초기화
            event.preventDefault();

            // ajax 객체 설정
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                data: new FormData(this),
                processData: false,
                contentType: false,
                dataType:'json'

                // 통신 완료
            }).done(function(data) {
                // 조회 데이터가 없을 경우 => 함수 종료
                if(data.length <= 0) {
                    alert('조회된 데이터가 없습니다.');
                    return;
                }

                let listNum = 0;

                // 학생 목록
                let listTBody = $('#import_student_list');
                // 학생 분류
                let classList = $('#select_class');
                listTBody.empty();
                classList.empty();
                // 1번째 배열 순환 : 학생 유형별 순환
                for(let classOfStudent in data) {

                    // 학생 분류 체크버튼 추가 => 해당 그룹을 클릭하면 그 그룹에 소속된 모든 학생 선택
                    let createSpan = $('<span>');
                    let createCheck = $(`<input type='checkbox' value='${classOfStudent}' id='select_${classOfStudent}'>`);
                    let createLabel = $(`<label for="select_${classOfStudent}">`).text(classOfStudent);

                    // 체크박스를 체크했을 시 발생 이벤트
                    createCheck.change(function() {
                        // 해당 유형에 소속된 학생 체크 실시 or 해제하기
                        for(let student in data[classOfStudent]) {
                            if($(this).is(':checked')) {
                                $(`#student_${data[classOfStudent][student].id}`).attr('checked', true);
                            } else {
                                $(`#student_${data[classOfStudent][student].id}`).attr('checked', false);
                            }
                        }
                    });

                    // 엘리멘트 할당
                    createSpan.append(createLabel);
                    createSpan.append(createCheck);
                    classList.append(createSpan);

                    // 2번째 순환: 각 유형별 학생 리스트
                    for(let student in data[classOfStudent]) {
                        // 행 생성
                        let createTr = $("<tr>");

                        // 1번째 칸 : 체크박스
                        let createTd = $("<td>");
                        let createInput = $(`<input type='checkbox' name='student_list[${listNum++}]'
                                    value='${data[classOfStudent][student].id}' id='student_${data[classOfStudent][student].id}'>`);
                        createInput.data('myClass', classOfStudent);
                        createTd.append(createInput);
                        createTr.append(createTd);

                        // 2번째 칸 : 학번
                        createTd = $("<td>");
                        createTd.append($(`<label for="student_${data[classOfStudent][student].id}">`)
                            .text(data[classOfStudent][student].id));
                        createTr.append(createTd);

                        // 3번째 칸 : 이름
                        createTd = $("<td>");
                        createTd.append($(`<label id='name_${data[classOfStudent][student].id}'
                                    for="student_${data[classOfStudent][student].id}">`)
                            .text(data[classOfStudent][student].name));
                        createTr.append(createTd);

                        // 4번째 칸 : 반
                        createTd = $("<td>");
                        createTd.text(data[classOfStudent][student].class);
                        createTr.append(createTd);

                        // 5번째 칸 : 유형
                        createTd = $("<td>");
                        createTd.text(data[classOfStudent][student].type);
                        createTr.append(createTd);

                        // 테이블에 행을 추가
                        listTBody.append(createTr);
                    }
                }
                // 페이드인 이벤트
                import_student_modal.fadeIn();
            });
        });

        // 학생 등록 이벤트 재정의
        $('#insert_student').submit(function(event) {
            let dataList = $(this).serializeArray();
            let returnValueList = [];

            for(let selected in dataList) {
                if(dataList[selected].name === '_token') {
                    continue;
                }

                let tempArray = [];
                let std_id  = dataList[selected].value;
                let name    = $(`#name_${std_id}`).text();

                tempArray['std_id'] = std_id;
                tempArray['name']   = name;

                returnValueList.push(tempArray);
            }


            // 전송
            event.preventDefault();
        });
    </script>
@endsection