<?php

use Illuminate\Database\Seeder;

class caste_concession_table_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('caste_concession')->insert([
            [

                'fee_id' => 1,
                'caste_id' => 1,
                'concession_amount' => 1500,

            ],
            [

                'fee_id' => 2,
                'caste_id' => 2,
                'concession_amount' => 900,

            ],
            [

                'fee_id' => 3,
                'caste_id' => 3,
                'concession_amount' => 1000,

            ],
            [

                'fee_id' => 4,
                'caste_id' => 4,
                'concession_amount' => 500,

            ]
        ]);
    }
}
