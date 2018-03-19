<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 클래스명:                       CreateScoresTable
 * 클래스 설명:                    성적 데이터 테이블을 만드는 마이그레이션
 * 만든이:                         3-WDJ 1401213 이승민
 * 만든날:                         2018년 3월 18일
 */
class CreateScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scores', function (Blueprint $table) {
            /**
             *  01. 칼럼 정의
             *  lecture_id              unsigned int        foreign key(lecture->id), not null
             *                          : 해당 성적 데이터가 발생한 강의 데이터 번호
             *
             *  id                      unsigned int        primary key, auto increment
             *                          : 데이터 구분 번호
             *
             *  reg_date                date                not null
             *                          : 데이터 기록 일자
             *
             *  type                    unsigned int(1)     not null
             *                          : 성적 유형
             *
             *  content                 text                not null
             *                          : 상세 설명
             *
             *  perfect_score           unsigned int(3)     not null
             *                          : 만점
             */
            $table->integer('lecture_id', FALSE, TRUE);
            $table->increments('id');
            $table->date('reg_date');
            $table->tinyInteger('type', FALSE, TRUE);
            $table->text('content');
            $table->smallInteger('perfect_score', FALSE, TRUE);

            // 02. 제약조건 정의
            /*$table->primary('id');*/
            $table->foreign('lecture_id')->references('id')->on('lectures')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scores');
    }
}
