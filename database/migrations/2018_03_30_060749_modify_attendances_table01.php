<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 클래스명:                       ModifyAttendancesTable01
 * 클래스 설명:                    출석 데이터의 첫번째 변경에 대해 관리하는 마이그레이션
 * 만든이:                         3-WDJ 1401213 이승민
 * 만든날:                         2018년 3월 30일
 */
class ModifyAttendancesTable01 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         *  DB 스키마 변경 내역
         *
         *  작성일자    : 2018년 3월 30일
         *  작성자      : 1401213 이승민
         *
         *  이슈 발생 테이블: attendances (출석)
         *  이슈: 결석 데이터 추출 과정에서 사유가 있는 결석과 무단 결석을 구분할 수 없음
         *
         *  변경 요소
         *      Attendances (출석)
         *           새로운 칼럼 추가
         *              	absence_flag (Boolean)
         *                  	결석여부 확인 플래그
         *                  	기본값: NULL, 제약조건: X
         *                  	출석 = NULL, 사유 결석 = TRUE, 무단 결석 = FALSE
         *          	기존 칼럼의 변경
         *              	come_school (int) – 제약조건 변경
         *                  	등교 데이터 번호
         *                  	변경: NOT NULL 제약조건 삭제
         */

        Schema::table('attendances', function(Blueprint $table) {
            $table->unsignedInteger('come_school')->nullable()->change();
            //$table->boolean('absence_flag')->nullable()->default(NULL);
            $table->addColumn('boolean', 'absence_flag')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('attendances', function(Blueprint $table) {
            $table->unsignedInteger('come_school')->nullable(false)->change();
            $table->dropColumn('absence_flag');
        });
    }
}
