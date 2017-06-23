<?php

use Illuminate\Database\Seeder;

class extra_categories_table_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('extra_categories')->insert([
        [
          'categories'=> 'CASTE',
           'slug' => 'caste'
        ],
        [
          'categories'=> 'DEFENCE',
           'slug' => 'defence'
        ],
        [
          'categories'=> 'DIFFERENTLY ABLED',
           'slug' => 'differently_abled'
        ],
        [
          'categories'=> 'Not Applicable',
           'slug' => 'na'
        ],
      ]);
    }
}
