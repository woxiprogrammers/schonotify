<?php

use Illuminate\Database\Seeder;

class fee_particular_tabel_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('fee_particulars')->insert([
            [
                'slug' => 'admission_fees',
                'particular_name' => 'Admission Fees'

            ],
            [
                'slug' => 'computer_lab',
                'particular_name' => 'Computer Lab'

            ],
            [
                'slug' => 'building_maintenance',
                'particular_name' => 'Building Maintenance'

            ],
        ]);
    }
}
