<?php

use Illuminate\Database\Seeder;

class transaction_type extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('transaction_types')->insert([
           [
               'transaction_type' => 'Cash',
                'slug' => 'cash'
           ] ,
           [
               'transaction_type' => 'NEFT',
               'slug' => 'neft'
           ]

        ]);
    }
}
