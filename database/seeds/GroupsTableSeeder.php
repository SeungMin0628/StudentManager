<?php

use Illuminate\Database\Seeder;
use App\Professor;
use App\Group;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $professors = Professor::getTutors();

        $professors->each(function ($professor) {
            $professor->group()->save(
                factory(Group::class)->make()
            );
        });
    }
}
