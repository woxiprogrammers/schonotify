<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ExamTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('exam_types')->insert([
            [
                'description' => 'written',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'description' => 'oral',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()

            ],
            [
                'description' => 'practical',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()

            ]
        ]);
    }
}
