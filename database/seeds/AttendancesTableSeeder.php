<?php

use Illuminate\Database\Seeder;
use App\Student;
use App\LeaveSchool;
use App\ComeSchool;
use App\Attendance;
use App\Http\DbInfoEnum;
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
        $students = Student::all();
        $recent_attendance = new Carbon(Attendance::whereMonth(
            DbInfoEnum::ATTENDANCES['reg_date'], '>=', today()->startOfMonth()->format('m')
            )->max('reg_date'));

        for($iCount = $recent_attendance->day; $iCount <= $today->day; $iCount++) {
            foreach($students as $student) {
                $nowDate = Carbon::createFromDate($today->year, $today->month, $iCount);
                if(sizeof(Attendance::where([
                    [DbInfoEnum::ATTENDANCES['reg_date'], $nowDate->format('Y-m-d')],
                        [DbInfoEnum::ATTENDANCES['std_id'], $student->id]])->get()) > 0) {
                    continue;
                }

                // 등교 데이터 생성
                $come_hour      = random_int(6, 9);
                $zero_to_sixty  = random_int(0, 59);

                $come_school_time = Carbon::create($today->year, $today->month, $iCount, $come_hour, $zero_to_sixty, $zero_to_sixty);

                $come_school = new ComeSchool();
                $come_school->reg_time          = $come_school_time;
                $come_school->lateness_flag     = ($come_hour < 9) ? false : true;
                $come_school->classification    = ($come_hour < 9) ? 1 : 2;

                $come_school->save();

                // 하교 데이터 생성
                $leave_hour = random_int(20, 23);
                $leave_school_time = Carbon::create($today->year, $today->month, $iCount, $leave_hour, $zero_to_sixty, $zero_to_sixty);

                $leave_school = new LeaveSchool();
                $leave_school->reg_time         = $leave_school_time;
                $leave_school->early_flag       = ($leave_hour >= 21) ? false : true;
                $leave_school->classification   = ($leave_hour >= 21) ? 1 : 2;

                $leave_school->save();

                // 출석 데이터 생성
                $attendance = new Attendance();

                $attendance->reg_date       = Carbon::createFromDate($come_school_time->year, $come_school_time->month, $come_school_time->day);
                $attendance->std_id         = $student->id;
                $attendance->come_school    = $come_school->id;
                $attendance->leave_school   = $leave_school->id;

                $attendance->save();
            }
        }
    }
}
