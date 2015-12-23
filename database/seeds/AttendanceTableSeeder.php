<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class AttendanceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('attendance')->insert([
            [
                'teacher_id' => 10,
                'date' => Carbon::now(),
                'student_id' => 19,
                'status' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'teacher_id' => 10,
                'date' => Carbon::now(),
                'student_id' => 20,
                'status' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()

            ],
            [
                'teacher_id' => 10,
                'date' => Carbon::now(),
                'student_id' => 21,
                'status' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
    }
}
