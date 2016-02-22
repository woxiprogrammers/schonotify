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
                'class_id'=>1,
                'teacher_id'=>2,
                'subject_id'=>1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'division_id' => 2,
                'class_id'=>1,
                'teacher_id'=>2,
                'subject_id'=>1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ]);
    }
}
