<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class ExamsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('exams')->insert([
            [
                'exam_name' => 'Unit Test 1',
                'exam_type' => 1,
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now(),
                'duration' => 7,
                'pass_criteria' => 35,
                'venue'=> 'Pune',
                'slug' => 'unit_test_1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'exam_name' => 'Unit Test 2',
                'exam_type' => 1,
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now(),
                'duration' => 7,
                'pass_criteria' => 40,
                'venue'=> 'Pune',
                'slug' => 'unit_test_2',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
    }
}
