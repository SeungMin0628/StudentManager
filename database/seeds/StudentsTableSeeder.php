<?php

use Illuminate\Database\Seeder;

class StudentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $groups = App\Group::all();

        $groups->each(function ($group) {
            $group->students()->save(
                factory(App\Student::class, 20)->make()
            );
        });
    }
}
