<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 클래스명:                       CreateStudentTable
 * 클래스 설명:                    학생 데이터 테이블을 만드는 마이그레이션
 * 만든이:                         3-WDJ 1401213 이승민
 * 만든날:                         2018년 3월 18일
 */
class CreateStudentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student', function (Blueprint $table) {
            /**
             *  01. 칼럼 정의
             *  id          unsigned int(7) primary key
             *              : 학번
             *
             *  class       unsigned int    foreign key(class -> id)
             *              : 소속 반
             *
             *  password    varchar(100)    not null
             *              : 비밀번호
             *
             *  name        varchar930)     not null
             *              : 학생 이름
             *
             *  phone       char(11)        not null
             *              : 전화번호
             *
             *  email       varchar(50)     not null
             *              : 이메일
             *
             *  face_photo  varchar(40)     default null
             *              : 얼굴사진 위치 경로
             */
            $table->integer('id', 7)->unsigned();
            $table->integer('class')->unsigned();
            $table->string('password', 100);
            $table->string('name', 30);
            $table->char('phone', 11);
            $table->string('email', 50);
            $table->string('face_photo', 40)->nullable()->default(NULL);

            // 02. 제약조건 정의
            $table->primary('id');
            $table->foreign('class')->references('id')->on('class');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student');
    }
}
