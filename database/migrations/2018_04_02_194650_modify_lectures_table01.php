<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 클래스명:                       ModifyLecturesTable01
 * 클래스 설명:                    강의 테이블의 첫번째 변경에 대해 관리하는 마이그레이션
 * 만든이:                         3-WDJ 1401213 이승민
 * 만든날:                         2018년 4월 02일
 */
class ModifyLecturesTable01 extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //
        Schema::table('lectures', function(Blueprint $table) {
            $table->string('divided_class_id', 2)->nullable()->default(NULL)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
        Schema::table('lectures', function(Blueprint $table) {
            $table->string('divided_class_id', 2)->nullable(FALSE)->change();
        });
    }
}
