<?php

use Illuminate\Database\Seeder;

class Installments extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('installments')->insert([
            [
                'installment_number' => '1',

            ],
            [
                'installment_number' => '2',

            ],

            [
                'installment_number' => '3',

            ],
            [
                'installment_number' => '4',

            ],
            [
                'installment_number' => '5',

            ]



        ]);
    }
}
