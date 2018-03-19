<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 클래스명:                       CreateSubjectsTable
 * 클래스 설명:                    학기별 개설 과목 데이터 테이블을 만드는 마이그레이션
 * 만든이:                         3-WDJ 1401213 이승민
 * 만든날:                         2018년 3월 18일
 */
class CreateSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subjects', function (Blueprint $table) {
            /**
             *  01. 칼럼 정의
             *
             *  year            year            not null
             *                  : 개설 연도
             *
             *  term            int(1)          not null
             *                  : 개설 학기
             *
             *  class_id        unsigned int    foreign key(class->id), not null
             *                  : 개설 반
             *
             *  id              unsigned int(8) primary key
             *                  : 과목 코드
             *
             *  name            varchar(30)     not null
             *                  : 과목 이름
             *
             *  division_flag   boolean         not null, default false
             *                  : 분반 존재 여부
             */
            $table->year('year');
            $table->tinyInteger('term', FALSE, FALSE);
            $table->integer('group_id', FALSE, TRUE);
            $table->integer('id', FALSE, TRUE);
            $table->string('name', 30);
            $table->boolean('division_flag')->default(FALSE);

            // 02. 제약조건 정의
            $table->primary('id');
            $table->foreign('group_id')->references('id')->on('groups')->onUpdate('cascade')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subjects');
    }
}
