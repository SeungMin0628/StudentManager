<?php

use Illuminate\Database\Seeder;
use App\Classification;

class ClassificationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $reasons = [
            "정상", "무단", "개인사정", "질병", "고향", "사고", "천재지변", "기타"
        ];

        foreach($reasons as $reason) {
            $clf = new Classification();
            $clf->content = $reason;
            $clf->save();
        }
    }
}
