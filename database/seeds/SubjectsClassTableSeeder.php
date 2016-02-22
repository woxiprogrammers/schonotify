<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SubjectsClassTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('subject_classes')->insert([
            [
                'class_id' => 1,
                'subject_id'=>1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'class_id' =>1,
                'subject_id'=>2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'class_id' =>2,
                'subject_id'=>3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'class_id' =>2,
                'subject_id'=>4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'class_id' =>3,
                'subject_id'=>5,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'class_id' =>3,
                'subject_id'=>6,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],


        ]);
    }
}
