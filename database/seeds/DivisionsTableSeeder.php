<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DivisionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('divisions')->insert([
            [
                'division_name' => 'A',
                'class_id'=>1,
                'class_teacher_id'=>2,
                'operational_days'=>6,
                'slug'=>'a',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'division_name' => 'B',
                'class_id'=>1,
                'class_teacher_id'=>3,
                'operational_days'=>6,
                'slug'=>'b',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'division_name' => 'C',
                'class_id'=>2,
                'class_teacher_id'=>4,
                'operational_days'=>6,
                'slug'=>'c',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'division_name' => 'D',
                'class_id'=>2,
                'class_teacher_id'=>0,
                'operational_days'=>6,
                'slug'=>'d',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'division_name' => 'E',
                'class_id'=>3,
                'class_teacher_id'=>0,
                'operational_days'=>6,
                'slug'=>'e',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'division_name' => 'F',
                'class_id'=>3,
                'class_teacher_id'=>0,
                'operational_days'=>6,
                'slug'=>'e',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],

        ]);
    }
}
