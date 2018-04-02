<?php

use Illuminate\Database\Seeder;
use App\Professor;
use App\Group;
use App\Student;
use App\Classification;
use App\Attendance;
use App\Classroom;
use App\Subject;
use App\Lecture;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        if(config('database.default') !== 'sqlite') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
        }

        // 더미 데이터 삽입 시더
        Professor::truncate();
        $this->call(ProfessorsTableSeeder::class);

        Group::truncate();
        $this->call(GroupsTableSeeder::class);

        Student::truncate();
        $this->call(StudentsTableSeeder::class);

        Classification::truncate();
        $this->call(ClassificationsTableSeeder::class);

        Attendance::truncate();
        $this->call(AttendancesTableSeeder::class);

        Classroom::truncate();
        $this->call(ClassroomsTableSeeder::class);

        Subject::truncate();
        $this->call(SubjectsTableSeeder::class);

        Lecture::truncate();
        $this->call(LecturesTableSeeder::class);

        if(config('database.default') !== 'sqlite') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }
    }
}
