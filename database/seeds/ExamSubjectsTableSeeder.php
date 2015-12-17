<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ExamSubjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('exam_subjects')->insert([
            [
                'exam_id' => 1,
                'subject_id' => 1,
                'date' => Carbon::now(),
                'marks' => 50,
                'passing_marks' => 20,
                'publish_status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'exam_id' => 1,
                'subject_id' => 2,
                'date' => Carbon::now(),
                'marks' => 50,
                'passing_marks' => 20,
                'publish_status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'exam_id' => 1,
                'subject_id' => 3,
                'date' => Carbon::now(),
                'marks' => 50,
                'passing_marks' => 20,
                'publish_status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'exam_id' => 2,
                'subject_id' => 1,
                'date' => Carbon::now(),
                'marks' => 50,
                'passing_marks' => 20,
                'publish_status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'exam_id' => 2,
                'subject_id' => 2,
                'date' => Carbon::now(),
                'marks' => 50,
                'passing_marks' => 20,
                'publish_status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'exam_id' => 2,
                'subject_id' => 3,
                'date' => Carbon::now(),
                'marks' => 50,
                'passing_marks' => 20,
                'publish_status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
    }
}
