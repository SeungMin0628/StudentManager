<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 클래스명:                       CreateTimetablesTable
 * 클래스 설명:                    강의 시간표 데이터 테이블을 만드는 마이그레이션
 * 만든이:                         3-WDJ 1401213 이승민
 * 만든날:                         2018년 3월 18일
 */
class CreateTimetablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timetables', function (Blueprint $table) {
            /**
             *  01. 칼럼 정의
             *
             *  id              unsigned int        primary key, auto increment
             *                  : 데이터 순번
             *
             *  lecture_id      unsigned int        foreign key(lecture->id), not null
             *                  : 강의 코드
             *
             *  day_of_week     unsigned int(1)     not null
             *                  : 요일 데이터
             *
             *  period          unsigned int(2)     not null
             *                  : 강의 교시
             *
             *  classroom_id    unsigned int        foreign key(classroom->id), not null
             *                  : 강의 장소
             */
            $table->increments('id');
            $table->integer('lecture_id', FALSE, TRUE);
            $table->tinyInteger('day_of_week', FALSE, TRUE);
            $table->tinyInteger('period', FALSE, TRUE);
            $table->integer('classroom_id', FALSE, TRUE);

            // 02. 제약조건 설정
            /*$table->primary('id');*/
            $table->foreign('lecture_id')->references('id')->on('subjects')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('classroom_id')->references('id')->on('classrooms')->onUpdate('cascade')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('timetables');
    }
}
