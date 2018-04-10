<?php
/**
 * 페이지 설명: <교과목 교수> 성적 등록 페이지
 * User: Seungmin Lee
 * Date: 2018-04-09
 * Time: 오전 10:24
 */
?>
@section('style')
    <style type="text/css">
        .modal_layout {
            display:none;
            position:relative;
        }

        .modal_content {
            width:440px;
            height:200px;
            padding:20px;
            border:1px solid #ccc;
            top:    50%;
            left:   50%;
            position:fixed;
            z-index:11;
        }

        .modal_content button{
            position:absolute;
            right:0;
            top:0;
            cursor:pointer;
        }
    </style>
@endsection
@extends('layouts.professor_master')
@section('body.section')
    <!-- 인터페이스 최상위 div -->
    <div class="div-table-master">
        <!-- 좌측 div : 엑셀 등록 관련 인터페이스 -->
        <div class="div-table-column">
            <div class="div-table-td btn-link" id="export_link">엑셀 양식 다운로드</div>
            <div class="div-table-td btn-link" id="import_link">엑셀 입력</div>
        </div>
        <!-- 우측 div : 직접 등록 버튼 -->
        <div>
            <div class="div-table-td">직접 입력</div>
        </div>
    </div>

    <!-- 엑셀 출력 양식 모달 창 -->
    <div id="export_excel" class="modal_layout">
        <div class="modal_content">
            <button type="button">@lang('interface.close')</button>
            <form action="{{ route('professor.scores.store.excel.export') }}" method="post">
                {!! csrf_field() !!}
                <!-- 파일 이름 입력창 -->
                <div>
                    <label for="file_name">@lang('interface.file_name')</label>
                    <input type="text" name="file_name" id="file_name" maxlength="30" required>
                </div>

                <!-- 성적 유형 선택창 -->
                <div>
                    <label for="score_type">@lang('lecture.type')</label>
                    <select name="score_type" id="score_type">
                        <option value="1">@lang('lecture.midterm')</option>
                        <option value="2">@lang('lecture.final')</option>
                        <option value="3" selected>@lang('lecture.task')</option>
                        <option value="4">@lang('lecture.quiz')</option>
                    </select>
                </div>

                <!-- 만점 설정창 -->
                <div>
                    <label for="perfect_score">@lang('lecture.gettable_score')</label>
                    <input type="number" name="perfect_score" id="perfect_score" min="1" max="999" required>
                </div>

                <!-- 성적 상세 내용 입력창 -->
                <div>
                    <label for="content">@lang('lecture.score_content')</label>
                    <input type="text" name="content" id="content" minlength="2" maxlength="30" required>
                </div>

                <!-- 출력 파일 유형 입력 -->
                <div>
                    <label for="file_type">@lang('interface.file_type')</label>
                    <select name="file_type" id="file_type">
                        <option value="xlsx">xlsx</option>
                        <option value="xls">xls</option>
                        <option value="csv">csv</option>
                    </select>
                </div>

                <!-- 전송 버튼 -->
                <div>
                    <input type="submit" value="@lang('interface.form_download')">
                </div>
            </form>
        </div>
    </div>

    <!-- 엑셀 입력 모달창 -->
    <div id="import_excel" class="modal_layout">
        <div class="modal_content">
            <!-- 닫기 버튼 -->
            <button type="button">@lang('interface.close')</button>
            <!-- 전송 form -->
            <form  enctype="multipart/form-data" action="{{ route('professor.scores.store.excel.import') }}" method="post">
                {!! csrf_field() !!}

                <!-- 파일 입력창 -->
                <div>
                    <input type="file" name="upload_file" id="upload_file" required
                        accept=".xlsx, .xls, .csv">
                </div>
                <!-- 전송 -->
                <div>
                    <input type="submit" value="@lang('interface.score_upload')">
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script language="JavaScript">
        $(document).ready(function() {
            // 변수 선언
            let exportExcel     = $('#export_excel');
            let exportLink      = $('#export_link');

            let importExcel     = $('#import_excel');
            let importLink      = $('#import_link');

            /* 엑셀 출력 양식 모달창 출력 */
            // 엑셀 양식 다운로드할 시 적용할 내용을 작성하는 양식 입력창 출력
            exportLink.click(function () {
                // 현재 파일 입력창이 출력되어 있을 경우 => 자동 닫기
                if(importExcel.css('display') !== "none") {
                    importExcel.fadeOut(400, function() {
                        exportExcel.fadeIn();
                    });
                } else {
                    exportExcel.fadeIn();
                }
            });

            // 입, 출력 모달창 닫기
            $('.modal_content > button').click(function() {
                importExcel.fadeOut();
                exportExcel.fadeOut();
            });

            /* 엑셀 파일 입력 모달창 출력 */
            // 엑셀 파일을 업로드하는 양식 출력
            importLink.click(function() {
                // 현재 양식 다운로드 창이 출력되어 있을경우 => 자동 닫기
                if(exportExcel.css('display') !== "none") {
                    exportExcel.fadeOut(400, function() {
                        importExcel.fadeIn();
                    });
                    // 아니면 그냥 출력
                } else {
                    importExcel.fadeIn();
                }
            });
        });
    </script>
@endsection