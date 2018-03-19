<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 클래스명:                       CreateCheckInLecturesTable
 * 클래스 설명:                    강의 중 출결 확인 데이터 테이블을 만드는 마이그레이션
 * 만든이:                         3-WDJ 1401213 이승민
 * 만든날:                         2018년 3월 18일
 */
class CreateCheckInLecturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('check_in_lectures', function (Blueprint $table) {
            /**
             *  01. 칼럼 정의
             *
             *  id          unsigned int    primary key
             *              : 데이터 순번
             *
             *  lecture_id  unsigned int    foreign key(lecture->id), not null
             *              : 출결을 실시한 강의 ID
             *
             *  std_id      unsigned int(7) foreign key(student->id), not null
             *              : 출석한 학생의 ID
             *
             *  reg_time    datetime        not null
             *              : 데이터 등록 일시
             */
            $table->increments('id');
            $table->integer('lecture_id', FALSE, TRUE);
            $table->integer('std_id', FALSE, TRUE);
            $table->datetime('reg_time');

            // 02. 제약조건 설정
            /*$table->primary('id');*/
            $table->foreign('lecture_id')->references('id')->on('lectures')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('std_id')->references('id')->on('students')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('check_in_lectures');
    }
}
