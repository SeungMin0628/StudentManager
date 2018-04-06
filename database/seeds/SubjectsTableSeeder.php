<?php

use Illuminate\Database\Seeder;
use App\Subject;
use App\Group;

/**
 * 클래스명:                       SubjectsTableSeeder
 * 클래스 설명:                    과목 더미 데이터를 생성하는 시더
 * 만든이:                         3-WDJ 8조 春目指す 1401213 이승민
 * 만든날:                         2018년 4월 02일
 */
class SubjectsTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        //
        //factory(Subject::class, 30)->create();

        $groups = Group::all();

        $groups->each(function($group) {
            // 전공 과목 - 분반 생성
            $major = new Subject();

            $major->year            = 2018;
            $major->term            = 1;
            $major->group_id        = $group->id;
            $major->id              = random_int(10000000, 99999999);
            $major->name            = "WEB PROGRAMMING";
            $major->division_flag   = TRUE;

            $major->save();

            // 일본어 과목 - 단일
            $japanese = new Subject();

            $japanese->year            = 2018;
            $japanese->term            = 1;
            $japanese->group_id        = $group->id;
            $japanese->id              = random_int(10000000, 99999999);
            $japanese->name            = "BUSINESS JAPANESE";
            $japanese->division_flag   = FALSE;

            $japanese->save();
        });
    }
}
