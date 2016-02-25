<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class TeacherViewTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('teacher_views')->insert([
            [
                'user_id' => 2,
                'mobile_view'=>1,
                'web_view'=>1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'user_id' => 3,
                'mobile_view'=>1,
                'web_view'=>1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'user_id' => 4,
                'mobile_view'=>1,
                'web_view'=>1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ]);
    }
}
