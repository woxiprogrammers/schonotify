<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DivisionSubjectTableSeeder extends Seeder
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
                'teacher_id' => 15,
                'subject_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'division_id' => 1,
                'teacher_id' => 16,
                'subject_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()

            ]
        ]);
    }
}
