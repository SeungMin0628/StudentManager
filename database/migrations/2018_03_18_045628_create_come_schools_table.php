<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 클래스명:                       CreateComeSchoolsTable
 * 클래스 설명:                    등교 데이터 테이블을 만드는 마이그레이션
 * 만든이:                         3-WDJ 1401213 이승민
 * 만든날:                         2018년 3월 18일
 */
class CreateComeSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('come_schools', function (Blueprint $table) {
            /**
             *  01. 칼럼 정의
             *  id              unsigned int    primary key, auto increment
             *                  : 데이터 구분 번호
             *
             *  reg_time        datetime        not null
             *                  : 등교 시각
             *
             *  lateness_flag   boolean         not null, default false
             *                  : 지각 구분
             *
             *  classification  unsigned int    foreign key(classification->id)
             *                  : 등교 유형
             */
            $table->increments('id');
            $table->datetime('reg_time');
            $table->boolean('lateness_flag')->default(FALSE);
            $table->integer('classification', FALSE, TRUE);

            // 02. 제약조건 설정
            /*$table->primary('id');*/
            $table->foreign('classification')->references('id')->on('classifications')->onUpdate('cascade')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('come_schools');
    }
}