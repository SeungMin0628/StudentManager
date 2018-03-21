<?php

use Illuminate\Database\Seeder;

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

        App\Professor::truncate();
        $this->call(ProfessorsTableSeeder::class);

        App\Group::truncate();
        $this->call(GroupsTableSeeder::class);

        App\Student::truncate();
        $this->call(StudentsTableSeeder::class);

        if(config('database.default') !== 'sqlite') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }
    }
}
