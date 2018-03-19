<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 클래스명:                       CreateNeedCareAlertsTable
 * 클래스 설명:                    관심학생 알림 설정 데이터 테이블을 만드는 마이그레이션
 * 만든이:                         3-WDJ 1401213 이승민
 * 만든날:                         2018년 3월 18일
 */
class CreateNeedCareAlertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('need_care_alerts', function (Blueprint $table) {
            /**
             *  01. 칼럼 정의
             *  id                  unsigned int        primary key, auto increment
             *                      : 데이터 순번
             *
             *  manager             varchar(30)         foreign key(professor->id)
             *                      : 알림 관리 교수 아이디
             *
             *  days_unit           unsigned int(3)     not null
             *                      : 출결 데이터 취합 일자 단위
             *
             *  notification_flag   int(1)              not null
             *                      : 알림 조건 설정 코드
             *
             *  needed_count        unsigned int(3)     not null
             *                      : 조건 횟수
             *
             *  alert_std_flag      boolean             not null, default true
             *                      : 학생에게 알림 전송 여부
             *
             *  alert_prof_flag     boolean             not null, default ture
             *                      : 지도교수에게 알림 전송 여부
             */
            $table->increments('id');
            $table->string('manager', 30);
            $table->smallInteger('days_unit', FALSE, TRUE);
            $table->tinyInteger('notification_flag', FALSE, TRUE);
            $table->smallInteger('needed_count', FALSE, TRUE);
            $table->boolean('alert_std_flag')->default(TRUE);
            $table->boolean('alert_prof_flag')->default(TRUE);

            // 02. 제약조건 설정
            /*$table->primary('id');*/
            $table->foreign('manager')->references('id')->on('professors')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('need_care_alerts');
    }
}