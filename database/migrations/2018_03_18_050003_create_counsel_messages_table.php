<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 클래스명:                       CreateCounselMessagesTable
 * 클래스 설명:                    상담 요청 및 응답시 주고받은 메시지를 저장하는 테이블을 만드는 마이그레이션
 * 만든이:                         3-WDJ 1401213 이승민
 * 만든날:                         2018년 3월 18일
 */
class CreateCounselMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('counsel_messages', function (Blueprint $table) {
            /**
             *  01. 칼럼 정의
             *
             *  id                  unsigned int        primary key, auto increment
             *                      : 데이터 순번
             *
             *  counsel_id          unsigned int        foreign key(counsel->id), not null
             *                      : 관련 상담 ID
             *
             *  receiver_flag       boolean             not null
             *                      : 수신자 구분
             *
             *  read_mark           boolean             not null, default false
             *                      : 메시지 읽음 표시
             *
             *  wanted_time         datetime            not null
             *                      : 상담 희망 일시
             *
             *  content             text                not null
             *                      : 메시지 내용
             */
            $table->increments('id');
            $table->integer('counsel_id', FALSE, TRUE);
            $table->boolean('receiver_flag');
            $table->boolean('read_mark')->default(FALSE);
            $table->datetime('wanted_time');
            $table->text('content');

            // 02. 제약조건 설정
            /*$table->primary('id');*/
            $table->foreign('counsel_id')->references('id')->on('counsels')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('counsel_messages');
    }
}
