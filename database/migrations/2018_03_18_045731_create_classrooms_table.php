<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 클래스명:                       CreateClassroomsTable
 * 클래스 설명:                    강의실 데이터 테이블을 만드는 마이그레이션
 * 만든이:                         3-WDJ 1401213 이승민
 * 만든날:                         2018년 3월 18일
 */
class CreateClassroomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classrooms', function (Blueprint $table) {
            /**
             *  01. 칼럼 정의
             *
             *  id          unsigned int    primary key
             *              : 데이터 순번
             *
             *  name        varchar(20)     not null
             *              : 강의실 이름
             */
            $table->increments('id');
            $table->string('name', 20);

            // 02. 제약조건 설정
            /*$table->primary('id');*/
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('classrooms');
    }
}
