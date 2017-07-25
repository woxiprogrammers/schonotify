<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class DivisionSubjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('division_subjects')->insert([
            [
                'division_id' => 1,
                'teacher_id'=>2,
                'subject_id'=>1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'division_id' => 2,
                'teacher_id'=>2,
                'subject_id'=>4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'division_id' => 3,
                'teacher_id'=>3,
                'subject_id'=>2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'division_id' => 4,
                'teacher_id'=>3,
                'subject_id'=>3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'division_id' => 5,
                'teacher_id'=>4,
                'subject_id'=>5,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'division_id' => 6,
                'teacher_id'=>4,
                'subject_id'=>6,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
    }
}
