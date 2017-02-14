<?php

use Illuminate\Database\Seeder;

class caste_categories_table_seeder extends Seeder
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
                    'caste_category' => 'OBC',
                    'slug' => 'obc',

                ],
                [
                    'caste_category' => 'OPEN',
                    'slug' => 'open',

                ],
                [
                    'caste_category' => 'SC',
                    'slug' => 'sc',

                ],
                [
                    'caste_category' => 'ST',
                    'slug' => 'st',

                ],
                [
                    'caste_category' => 'NT',
                    'slug' => 'nt',

                ],

                [
                    'caste_category' => 'VJNT',
                    'slug' => 'vjnt',

                ]



            ]

        );
    }
}
