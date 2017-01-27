<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class SubjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('subjects')->insert([
            [
                'subject_name' => 'Marathi',
                'description'=>'',
                'slug'=>'marathi',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'subject_name' => 'English',
                'description'=>'',
                'slug'=>'english',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'subject_name' => 'Science',
                'description'=>'',
                'slug'=>'science',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'subject_name' => 'Maths',
                'description'=>'',
                'slug'=>'maths',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'subject_name' => 'Computer',
                'description'=>'',
                'slug'=>'computer',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'subject_name' => 'Hindi',
                'description'=>'',
                'slug'=>'hindi',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],

        ]);
    }
}
