<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ClassesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('classes')->insert([
            [
                'class_name' => 'First',
                'body_id'=>1,
                'batch_id'=>1,
                'slug'=>'first',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'class_name' => 'Second',
                'body_id'=>1,
                'batch_id'=>1,
                'slug'=>'second',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'class_name' => 'Third',
                'body_id'=>1,
                'batch_id'=>2,
                'slug'=>'third',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ]);
    }
}
