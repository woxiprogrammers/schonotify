<?php

use Illuminate\Database\Seeder;

class CasteConcessionTableSeeders extends Seeder
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
                    'caste_category' => 'SC',
                    'slug' => 'sc',

                ],  [
                    'caste_category' => 'ST',
                    'slug' => 'st',

                ],  [
                    'caste_category' => 'VJ(A)',
                    'slug' => 'vja',

                ],  [
                    'caste_category' => 'NT(B)',
                    'slug' => 'ntb',

                ],  [
                    'caste_category' => 'NT(C)',
                    'slug' => 'ntc',

                ],  [
                    'caste_category' => 'NT(D)',
                    'slug' => 'ntd',

                ],  [
                    'caste_category' => 'OBC',
                    'slug' => 'obc',

                ],
                [
                    'caste_category' => 'SBC',
                    'slug' => 'sbc',

                ],

                [
                    'caste_category' => 'OPEN',
                     'slug' => 'open',

                ],
                [
                     'caste_category' => 'MARATHA(ESBC)',
                     'slug' => 'marathaesbc',

                ],
                [
                    'caste_category' => 'MUSLIM(SBC-A)',
                    'slug' => 'muslimsbca',

                ],

            ]);
    }
}
