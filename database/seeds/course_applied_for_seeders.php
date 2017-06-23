<?php

use Illuminate\Database\Seeder;

class course_applied_for_seeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('course_applied_for')->insert([
          [
            'courses'=> 'FYBCOM',
             'slug' => 'fybcom'
          ],
          [
            'courses'=> 'FYBBA',
             'slug' => 'fybba'
          ],
          [
            'courses'=> 'FYBBA(IB)',
             'slug' => 'fybbaib'
          ],
          [
            'courses'=> 'FYBBA(CA)',
             'slug' => 'fybbaca'
          ]
        ]);
    }
}
