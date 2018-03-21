<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 클래스명:                       CreateProfessorsTable
 * 클래스 설명:                    교수 데이터 테이블을 만드는 마이그레이션
 * 만든이:                         3-WDJ 1401213 이승민
 * 만든날:                         2018년 3월 18일
 */
class CreateProfessorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('professors', function (Blueprint $table) {
            /**
             *  01. 칼럼 정의
             *  id          varchar(30)     primary key
             *              : 교수 ID
             *
             *  manager     varchar(30)     foreign key(professor->id) default null
             *              : (교과목 교수인 경우) 계정을 관리하는 지도교수
             *
             *  expire_date date            not null
             *              : (교과목 교수인 경우) 계정 만료시일
             *
             *  password    varchar(100)    not null
             *              : 비밀번호
             *
             * name         varchar(30)     not null
             *              : 교수 이름
             *
             *  phone       char(11)        not null
             *              : 연락처
             *
             *  email       varchar(50)     not null
             *              : 이메일
             *
             *  office      varchar(30)     not null
             *              : 연구실 위치
             *
             *  face_photo  varchar(40)     default null
             *              : 얼굴사진 위치 경로
             */
            $table->string('id', 30);
            $table->string('manager', 30)->nullable()->default(NULL);
            $table->date('expire_date')->nullable()->default(NULL);
            $table->string('password', 100);
            $table->string('name', 60);
            $table->char('phone', 11);
            $table->string('email', 50);
            $table->string('office', 30);
            $table->string('face_photo', 40)->default("");

            // 02. 제약조건 정의
            $table->primary('id');
            $table->foreign('manager')->references('id')->on('professors')->onUpdate('cascade')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('professors');
    }
}
