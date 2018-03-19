<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 클래스명:                       CreateAlertsTable
 * 클래스 설명:                    알람 관련 데이터 테이블을 만드는 마이그레이션
 * 만든이:                         3-WDJ 1401213 이승민
 * 만든날:                         2018년 3월 18일
 */
class CreateAlertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alerts', function (Blueprint $table) {
            /**
             *  01. 칼럼 정의
             *  id                  unsigned int        primary key, auto increment
             *                      : 데이터 순번
             *
             *  std_id              unsigned int(7)     foreign key(student->id), default null
             *                      : 알림 수신 대상 학생의 학번
             *
             *  prof_id             varchar(30)         foreign key(professor->id), default null
             *                      : 알림 수신 대상 교수의 아이디
             *
             *  content             text                not null
             *                      : 알림 내용
             *
             *  link                varchar(100)        not null
             *                      : 알림 내용에 맞는 페이지의 링크
             */
            $table->increments('id');
            $table->integer('std_id', FALSE, TRUE)->nullable()->default(NULL);
            $table->string('prof_id', 30)->nullable()->default(NULL);
            $table->text('content');
            $table->string('link', 100);

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
        Schema::dropIfExists('alerts');
    }
}
