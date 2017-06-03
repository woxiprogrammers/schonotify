<?php

use Illuminate\Database\Seeder;

class NewTransactionTypeTableSeeder extends Seeder
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
                'transaction_type' => 'Online Payment',
                'slug' => 'online'
            ]
        ]);
    }
}
