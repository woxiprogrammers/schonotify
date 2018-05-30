<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NewCasteCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('caste_categories')->insert([
            [
                'caste_category'=> 'DEFENCE',
                'slug' => 'defence'
            ],
            [
                'caste_category'=> 'DIFFERENTLY ABLED',
                'slug' => 'differently_abled'
            ],
        ]);
    }
}
