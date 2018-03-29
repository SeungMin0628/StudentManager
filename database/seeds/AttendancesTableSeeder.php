<?php

use Illuminate\Database\Seeder;
use App\Classification;
use App\LeaveSchool;
use App\ComeSchool;
use App\Attendance;
use Illuminate\Support\Carbon;

class AttendancesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        // 01. 변수 설정
        $today = today();
        $start_date = Carbon::createFromDate($today->year, $today->month, 1);

        $day_digits = $start_date->day;
    }
}
