<?php

use Illuminate\Database\Seeder;

class concession_types extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('concession_types')->insert([
            [
             'id' => 1,
             'name' => 'RTE',
             'slug' => 'rte',

            ],
            [
            'id' => 2,
             'name' => 'Caste',
             'slug' => 'caste',

            ],
            [
                'id' => 3,
                'name' => 'Special',
                'slug' => 'special',

            ],
            [
                'id' => 4,
                'name' => 'Sport',
                'slug' => 'sport',

            ]
        ]);
    }
}
