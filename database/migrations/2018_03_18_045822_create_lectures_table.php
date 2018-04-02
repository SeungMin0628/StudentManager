<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 클래스명:                       CreateLecturesTable
 * 클래스 설명:                    개설한 강의 데이터 테이블을 만드는 마이그레이션
 * 만든이:                         3-WDJ 1401213 이승민
 * 만든날:                         2018년 3월 18일
 */
class CreateLecturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lectures', function (Blueprint $table) {
            /**
             *  01. 칼럼 정의
             *
             *  id                      unsigned int        primary key, auto increment
             *                          : 데이터 순번
             *
             *  subject_id              unsigned int(8)     foreign key(subject->id), not null
             *                          : 과목 코드
             *
             *  divided_class_id        varchar(2)          default null
             *                          : 분반 코드
             *
             *  professor               varchar(30)         foreign key(professor->id), not null
             *                          : 담당 교수
             *
             *  attendance_reflection   decimal(3, 2)       not null, default 0.2
             *                          : 출석 반영 비율
             *
             *  midterm_reflection      decimal(3, 2)       not null, default 0.3
             *                          : 중간고사 반영 비율
             *
             *  final_reflection        decimal(3, 2)       not null, default 0.3
             *                          : 기말고사 반영 비율
             *
             *  task_reflection         decimal(3, 2)       not null, default 0.2
             *                          : 과제 반영 비율
             *
             *  quiz_reflection         decimal(3, 2)       not null, default 0
             *                          : 쪽지시험 반영 비율
             */
            $table->increments('id');
            $table->integer('subject_id', FALSE, TRUE);
            $table->string('divided_class_id', 2);
            $table->string('professor', 30);
            $table->decimal('attendance_reflection', 3, 2)->default(0.2);
            $table->decimal('midterm_reflection', 3, 2)->default(0.3);
            $table->decimal('final_reflection', 3, 2)->default(0.3);
            $table->decimal('task_reflection', 3, 2)->default(0.2);
            $table->decimal('quiz_reflection', 3, 2)->default(0);

            // 02. 제약조건 정의
            /*$table->primary('id');*/
            $table->foreign('subject_id')->references('id')->on('subjects')->onUpdate('cascade')->onDelete('no action');
            $table->foreign('professor')->references('id')->on('professors')->onUpdate('cascade')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lectures');
    }
}
