<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 클래스명:                       CreateAttendanceTable
 * 클래스 설명:                    출석 데이터 테이블을 만드는 마이그레이션
 * 만든이:                         3-WDJ 1401213 이승민
 * 만든날:                         2018년 3월 18일
 */
class CreateAttendanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance', function (Blueprint $table) {
            /**
             *  01. 칼럼 정의
             *  reg_date        date            not null
             *                  : 등/하교 일자
             *
             *  std_id          unsigned int(7) foreign key(student->id)
             *                  : 등/하교한 학생의 학번
             *
             *  come_school     unsigned int    foreign key(come_school->id)
             *                  : 등교 데이터 번호
             *
             *  leave_school    unsigned int    foreign key(leave_school->id), default null
             *                  : 하교 데이터 번호
             */
            $table->date('reg_date');
            $table->integer('std_id', 7)->unsigned();
            $table->integer('come_school')->unsigned();
            $table->integer('leave_school')->unsigned()->nullable()->default(NULL);

            /**
             *  02. 제약조건 설정
             *  unique index(reg_date, std_id)
             */
            $table->unique(['reg_date', 'std_id']);
            $table->foreign('come_school')->references('id')->on('come_school');
            $table->foreign('leave_school')->references('id')->on('leave_school');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendance');
    }
}