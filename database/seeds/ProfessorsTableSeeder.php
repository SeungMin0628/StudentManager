<?php

use Illuminate\Database\Seeder;
use App\Professor;

class ProfessorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(Professor::class, 3)->create();

        $tutors = Professor::getTutors()->all();

        foreach($tutors as $key => $tutor) {
            $tutor->face_photo = 'tutor_0'.($key + 1).".jpg";

            $tutor->save();
            for($iCount = 1; $iCount <= 3; $iCount++) {
                $professor = new Professor();

                $id = 'prof0'.(($key * sizeof($tutors)) + $iCount);

                $professor->id          = $id;
                $professor->manager     = $tutor->id;
                $professor->expire_date = "2018-12-31";
                $professor->password    = password_hash('password', PASSWORD_DEFAULT);
                $professor->name        = '교수'.(($key * sizeof($tutors)) + $iCount);
                $professor->phone       = '01012345678';
                $professor->email       = $id.'@exam.com';
                $professor->office      = "본관 999호";
                $professor->face_photo  = $id.'.jpg';

                $professor->save();
            }
        };
    }
}
