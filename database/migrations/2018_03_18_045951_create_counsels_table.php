<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 클래스명:                       CreateCounselsTable
 * 클래스 설명:                    상담에 필요한 데이터 테이블을 만드는 마이그레이션
 * 만든이:                         3-WDJ 1401213 이승민
 * 만든날:                         2018년 3월 18일
 */
class CreateCounselsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('counsels', function (Blueprint $table) {
            /**
             *  01. 칼럼 정의
             *
             *  id              unsigned int            primary key, auto increment
             *                  : 데이터 순번
             *
             *  std_id          unsigned int(7)         foreign key(student->id), not null
             *                  : 상담 대상 학생의 학번
             *
             *  prof_id         varchar(30)             foreign key(professor->id), not null
             *                  : 상담 교수의 아이디
             *
             *  reason          varchar(30)             not null
             *                  : 상담 사유
             *
             *  progress        varchar(20)             not null
             *                  : 상담 진척도
             */
            $table->increments('id');
            $table->integer('std_id', FALSE, TRUE);
            $table->string('prof_id', 30);
            $table->string('reason', 30);
            $table->string('progress', 20);

            // 02. 제약조건 설정
            /*$table->primary('id');*/
            $table->foreign('std_id')->references('id')->on('students')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('prof_id')->references('id')->on('professors')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('counsels');
    }
}
