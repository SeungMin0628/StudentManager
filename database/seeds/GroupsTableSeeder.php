<?php

use Illuminate\Database\Seeder;

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
        $professors = App\Professor::all();

        $professors->each(function ($professor) {
            $professor->group()->save(
                factory(App\Group::class)->make()
            );
        });
    }
}
