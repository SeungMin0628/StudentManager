<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 클래스명:                       CreateGainedScoresTable
 * 클래스 설명:                    학생이 취득한 점수 데이터 테이블을 만드는 마이그레이션
 * 만든이:                         3-WDJ 1401213 이승민
 * 만든날:                         2018년 3월 18일
 */
class CreateGainedScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gained_scores', function (Blueprint $table) {
            /**
             *  01. 칼럼 정의
             *
             *  id              unsigned int        primary key, auto increment
             *                  : 데이터 순번
             *
             *  score_type      unsigned int        foreign key(score->id), not null
             *                  : 성적 유형
             *
             *  std_id          unsigned int(7)     foreign key(student->id), not null
             *                  : 성적을 취득한 학생의 학번
             *
             *  score           unsigned int(3)     not null
             *                  : 취득 점수
             */
            $table->increments('id');
            $table->integer('score_type', FALSE, TRUE);
            $table->integer('std_id', FALSE, TRUE);
            $table->smallInteger('score', FALSE, TRUE);

            /**
             *  02. 제약조건 설정
             *
             *  unique index('score_type', 'std_id')
             */
            /*$table->primary('id');*/
            $table->foreign('score_type')->references('id')->on('scores')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('std_id')->references('id')->on('students')->onUpdate('cascade')->onDelete('cascade');
            $table->unique(['score_type', 'std_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gained_scores');
    }
}
