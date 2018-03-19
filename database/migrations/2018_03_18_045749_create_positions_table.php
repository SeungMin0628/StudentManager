<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 클래스명:                       CreatePositionsTable
 * 클래스 설명:                    학생 위치 데이터 테이블을 만드는 마이그레이션
 * 만든이:                         3-WDJ 1401213 이승민
 * 만든날:                         2018년 3월 18일
 */
class CreatePositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('positions', function (Blueprint $table) {
            /**
             *  01. 칼럼 정의
             *
             *  reg_time        datetime        not null
             *                  : 등록 일시
             *
             *  std_id          unsigned int(7) foreign key(student->id), not null
             *                  : 학번
             *
             *  attendance_flag boolean         not null
             *                  : 학생 출석 여부
             *
             *  gps_lat         decimal(9, 7)   not null
             *                  : GPS 위도
             *
             *  gps_long        decimal(9, 7)   not null
             *                  : GPS 경도
             */
            $table->datetime('reg_time');
            $table->integer('std_id', FALSE, TRUE);
            $table->boolean('attendance_flag');
            $table->decimal('gps_lat', 9, 7);
            $table->decimal('gps_long', 9, 7);

            /**
             *  02. 제약조건 설정
             *
             *   unique index('reg_time', 'std_id')
             */
            $table->foreign('std_id')->references('id')->on('students')->onUpdate('cascade')->onDelete('cascade');
            $table->unique(['reg_time', 'std_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('positions');
    }
}
