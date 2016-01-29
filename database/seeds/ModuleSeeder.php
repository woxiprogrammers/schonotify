<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('modules')->insert([
            [
                'title' => 'Exam',
                'slug' => 'exam',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [

                'title' => 'Attendance',
                'slug' => 'attendance',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'Event',
                'slug' => 'event',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'User',
                'slug' => 'user',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'Timetable',
                'slug' => 'timetable',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'Class',
                'slug' => 'class',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'Subject',
                'slug' => 'subject',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'Leave',
                'slug' => 'leave',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
             ],
            [
                'title' => 'Homework',
                'slug' => 'homework',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'Result',
                'slug' => 'result',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'Message',
                'slug' => 'message',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
    }
}
