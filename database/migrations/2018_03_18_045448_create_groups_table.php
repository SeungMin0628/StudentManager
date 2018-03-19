<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 클래스명:                       CreateGroupsTable
 * 클래스 설명:                    반 데이터를 저장하는 마이그레이션
 * 만든이:                         3-WDJ 1401213 이승민
 * 만든날:                         2018년 3월 18일
 */
class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            /**
             *  01. 칼럼 정의
             *  id              unsigned int    primary key, auto increment
             *                  : 데이터 순번
             *
             *  tutor           varchar(30)     foreign key(professor->id)
             *                  : 담당 지도교수
             *
             *  name            varchar(30)     not null
             *                  : 반 이름
             *
             *  school_time     time            not null, default '00:09:00'
             *                  : 등교 시간
             *
             *  home_time       time            not null, default '00:21:00'
             *                  : 하교 시간
             */
            $table->increments('id');
            $table->string('tutor', 30);
            $table->string('name', 30);
            $table->time('school_time')->default('00:09:00');
            $table->time('home_time')->default('00:21:00');

            // 02. 제약조건 설정
            /*$table->primary('id');*/
            $table->foreign('tutor')->references('id')->on('professors')->onUpdate('cascade')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('class');
    }
}
