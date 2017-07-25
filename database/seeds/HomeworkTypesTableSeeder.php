<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class HomeworkTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('homework_types')->insert([
            [
                'title' => 'assignment',
                'slug' =>'assignment',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'quiz',
                'slug' =>'quiz',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'class test',
                'slug' =>'class test',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ]);
    }
}
