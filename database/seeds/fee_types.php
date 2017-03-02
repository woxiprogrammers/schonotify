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
        DB::table('fee_types')->insert([
            [
            'fee_type' => 'Tution fees',
            'slug' => 'tution_fees',

            ],
            [
                'fee_type' => 'Activity fees',
                'slug' => 'activity_fees',

            ],
            [
                'fee_type' => 'Building and Maintenance',
                'slug' => 'building_and_maintenance',

            ],
            [
                'fee_type' => 'Icard and Diary',
                'slug' => 'icard_and_diary',

            ],
            [
                'fee_type' => 'CCA and Celebration',
                'slug' => 'cca_and_celebration',

            ],

            [
                'fee_type' => 'Examination',
                'slug' => 'examination',

            ],

            [
                'fee_type' => 'Admin Charges',
                'slug' => 'admin_charges',

            ],

            [
                'fee_type' => 'Admission Fees',
                'slug' => 'admission_fees',

            ],

            [
                'fee_type' => 'Term Fees',
                'slug' => 'term_fees',

            ],

            [
                'fee_type' => 'Computer Lab',
                'slug' => 'computer_lab',

            ],

            [
                'fee_type' => 'Library',
                'slug' => 'library',

            ],
            [
                'fee_type' => 'Refundable deposit',
                'slug' => 'refundable_deposit',

            ],

            [
                'fee_type' => 'Science Lab',
                'slug' => 'science_lab',

            ]




    ]

            );
    }
}
