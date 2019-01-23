<?php

use Illuminate\Database\Seeder;

class FullPaymentConcessionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('full_payment_concession_master')->insert([
            [
                'id' => 1,
                'name' => 'Full Payment',
                'slug' => 'full-payment',

            ]
        ]);
    }
}
