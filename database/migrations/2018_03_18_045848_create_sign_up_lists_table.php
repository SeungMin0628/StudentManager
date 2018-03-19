<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 클래스명:                       CreateSignUpListsTable
 * 클래스 설명:                    수강학생 목록 데이터 테이블을 만드는 마이그레이션
 * 만든이:                         3-WDJ 1401213 이승민
 * 만든날:                         2018년 3월 18일
 */
class CreateSignUpListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sign_up_lists', function (Blueprint $table) {
            /**
             *  01. 칼럼 정의
             *
             *  id              unsigned int        primary key, auto increment
             *                  : 데이터 순번
             *
             *  lecture_id      unsigned int        foreign key(lecture->id), not null
             *                  : 수강 강의 번호
             *
             *  std_id          unsigned int(7)     foreign key(student->id), not null
             *                  : 수강 학생 학번
             *
             *  achievement     decimal(3, 2)       not null, default 0
             *                  : 학업 성취도
             */
            $table->increments('id');
            $table->integer('lecture_id', FALSE, TRUE);
            $table->integer('std_id', FALSE, TRUE);
            $table->decimal('achievement', 3, 2)->default(0);

            /**
             *  02. 제약조건 설정
             *  unique index('lecture_id', 'std_id')`
             */
            $table->foreign('lecture_id')->references('id')->on('lectures')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('std_id')->references('id')->on('students')->onUpdate('cascade')->onDleete('cascade');
            $table->unique(['lecture_id', 'std_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sign_up_lists');
    }
}
