<?php

use Illuminate\Database\Seeder;

class fee_types extends Seeder
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
            'particular_name' => 'Tution fees',
            'slug' => 'tution_fees',

            ],
            [
                'particular_name' => 'Activity fees',
                'slug' => 'activity_fees',

            ],
            [
                'particular_name' => 'Building and Maintenance',
                'slug' => 'building_and_maintenance',

            ],
            [
                'particular_name' => 'Icard and Diary',
                'slug' => 'icard_and_diary',

            ],
            [
                'particular_name' => 'CCA and Celebration',
                'slug' => 'cca_and_celebration',

            ],

            [
                'particular_name' => 'Examination',
                'slug' => 'examination',

            ],

            [
                'particular_name' => 'Admin Charges',
                'slug' => 'admin_charges',

            ],

            [
                'particular_name' => 'Admission Fees',
                'slug' => 'admission_fees',

            ],

            [
                'particular_name' => 'Term Fees',
                'slug' => 'term_fees',

            ],

            [
                'particular_name' => 'Computer Lab',
                'slug' => 'computer_lab',

            ],

            [
                'particular_name' => 'Library',
                'slug' => 'library',

            ],
            [
                'particular_name' => 'Refundable deposit',
                'slug' => 'refundable_deposit',

            ],

            [
                'particular_name' => 'Science Lab',
                'slug' => 'science_lab',

            ]




    ]

            );
    }
}
