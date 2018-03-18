<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 클래스명:                       CreateBeaconTable
 * 클래스 설명:                    비콘 데이터 테이블을 만드는 마이그레이션
 * 만든이:                         3-WDJ 1401213 이승민
 * 만든날:                         2018년 3월 18일
 */
class CreateBeaconTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beacon', function (Blueprint $table) {
            /**
             *  01. 칼럼 정의
             *  id              unsigned int    primary key, auto increment
             *                  : 데이터 순번
             *
             *  site            unsigned int    foreign key(classroom->id), not null
             *                  : 위치 강의실 번호
             *
             *  uuid            varchar(32)     not null
             *                  : 비콘 UUID
             *
             *  major           unsigned int(5) not null
             *                  : 비콘 major
             *
             *  minor           unsigned int(5) not null
             *                  : 비콘 minor
             */
            $table->increments('id');
            $table->integer('site')->unsigned();
            $table->string('uuid', 32);
            $table->integer('major', 5)->unsigned();
            $table->integer('minor', 5)->unsigned();

            // 02. 제약조건 정의
            $table->primary('id');
            $table->foreign('site')->references('id')->on('classroom')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('beacon');
    }
}
