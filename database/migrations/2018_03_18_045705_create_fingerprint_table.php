<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 클래스명:                       CreateFingerprintTable
 * 클래스 설명:                    지문 데이터 테이블을 만드는 마이그레이션
 * 만든이:                         3-WDJ 1401213 이승민
 * 만든날:                         2018년 3월 18일
 */
class CreateFingerprintTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fingerprint', function (Blueprint $table) {
            /**
             *  01. 칼럼 정의
             *  id              unsigned int    primary key, auto increment
             *                  : 데이터 순번
             *
             *  std_id          unsigned int(7) foreign key(student->id)
             *                  : 소유 학생 학번
             *
             *  fingerprint     varchar(40)     unique, not null
             *
             */
            $table->increments('id');
            $table->integer('std_id', 7)->unsigned();
            $table->string('fingerprint', 40);

            // 02. 제약조건 설정
            $table->primary('id');
            $table->foreign('std_id')->references('id')->on('student')->onUpdate('cascade')->onDelete('cascade');
            $table->unique('fingerprint');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fingerprint');
    }
}
