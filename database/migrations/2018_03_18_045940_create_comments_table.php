<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
/**
 * 클래스명:                       CreateCommentsTable
 * 클래스 설명:                    교수가 학생에 대해 작성한 코멘트 데이터 테이블을 만드는 마이그레이션
 * 만든이:                         3-WDJ 1401213 이승민
 * 만든날:                         2018년 3월 18일
 */
class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            /**
             *  01. 칼럼 정의
             *
             *  id                  unsigned int            primary key, auto increment
             *                      : 데이터 순번
             *
             *  p_id                unsigned int            foreign key(comment->id), default null
             *                      : 부모 코멘트의 번호
             *
             *  std_id              unsigned int(7)         foreign key(student->id), not null
             *                      : 코멘트 대상 학생의 학번
             *
             *  prof_id             varchar(30)             foreign key(professor->id)
             *                      : 코멘트 작성 교수 아이디
             *
             *  content             text                    not null
             *                      : 코멘트 내용
             */
            $table->increments('id');
            $table->integer('p_id', FALSE, TRUE)->nullable();
            $table->integer('std_id', FALSE, TRUE);
            $table->string('prof_id', 30)->nullable();
            $table->text('content');

            // 02. 제약조건 설정
            /*$table->primary('id');*/
            $table->foreign('p_id')->references('id')->on('comments')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('std_id')->references('id')->on('students')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('prof_id')->references('id')->on('professors')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
