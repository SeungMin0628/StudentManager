<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 클래스명:                       ModifyCommentsTable01
 * 클래스 설명:                    코멘트 테이블의 첫번째 변경에 대해 관리하는 마이그레이션
 * 만든이:                         3-WDJ 1401213 이승민
 * 만든날:                         2018년 4월 09일
 */
class ModifyCommentsTable01 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('comments', function(Blueprint $table) {
            $table->year('year');
            $table->unsignedTinyInteger('term');
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
        Schema::table('comments', function(Blueprint $table) {
            $table->dropColumn(['year', 'term']);
        });
    }
}
