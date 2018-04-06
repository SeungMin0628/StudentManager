<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 클래스명:                       ModifyLecturesTable02
 * 클래스 설명:                    강의 테이블의 두번째 변경에 대해 관리하는 마이그레이션
 * 만든이:                         3-WDJ 1401213 이승민
 * 만든날:                         2018년 4월 04일
 */
class ModifyLecturesTable02 extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //
        /**
         *  DB 스키마 변경 내역
         *
         *  작성일자    : 2018년 4월 04일
         *  작성자      : 1401213 이승민
         *
         *  이슈 발생 테이블:  lectures (개설 강의)
         *  이슈: 오해로 인해 기존의 시스템 상 필요없는 칼럼이 생성되어 있음
         *
         *  변경 요소
         *      Attendances (출석)
         *          	기존 칼럼의 삭제
         *              	attendances_reflection (decimal) – 제약조건 변경
         *                  	출석 성적 반영 비율
         */
        Schema::table('lectures', function(Blueprint $table) {
            $table->decimal('quiz_reflection', 3, 2)->default(0.2)->change();
            $table->dropColumn('attendance_reflection');
        });
    }

    /**
    Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
        Schema::table('lectures', function(Blueprint $table) {
            $table->decimal('quiz_reflection')->default(0)->change();
            $table->decimal('attendance_reflection', 3, 2)->default(0.2);
        });
    }
}
