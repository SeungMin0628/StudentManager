<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 클래스명:                       CreateAccountSyncsTable
 * 클래스 설명:                    계정간 간편 로그인을 지원하기 위한 연결고리 데이터 테이블을 만드는 마이그레이션
 * 만든이:                         3-WDJ 1401213 이승민
 * 만든날:                         2018년 3월 18일
 */
class CreateAccountSyncsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_syncs', function (Blueprint $table) {
            /**
             *  01. 칼럼 정의
             *  prime_account       varchar(30)     foreign key(professor->id)
             *                      : 연결고리의 시작점
             *
             *  connected           varchar(30)     foreign key(professor->id)
             *                      : 연결된 계정
             */
            $table->string('prime_account', 30);
            $table->string('connected', 30);

            /**
             *  02. 제약조건 정의
             *  unique index(prime_account, connected)
             */
            $table->foreign('prime_account')->references('id')->on('professors')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('connected')->references('id')->on('professors')->onUpdate('cascade')->onDelete('cascade');
            $table->unique(['prime_account', 'connected']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account_syncs');
    }
}