<?php

use Illuminate\Database\Seeder;

class CasteCategoriesTableSeeder extends Seeder
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
                  'caste_category' => 'OPEN',
                  'slug' => 'open',              ],
              [
                  'caste_category' => 'S.C',
                  'slug' => 'sc',
              ],
              [
                  'caste_category' => 'S.T',
                  'slug' => 'st',
              ],
              [
                  'caste_category' => 'VIMUKTA_JATI(DTA)',
                  'slug' => 'dta',
              ],
              [
                  'caste_category' => 'N.T.B.(90)',
                  'slug' => 'ntb90',
              ],
              [
                  'caste_category' =>'N.T.C.(Dhangar and Sim)',
                  'slug' => 'ntc',
              ],
              [
                  'caste_category' => 'N.T.D.(Vanjari and Sim)',
                  'slug' => 'ntd',
              ],
              [
                  'caste_category' => 'O.B.C',
                  'slug' => 'obc',
              ],
              [
                  'caste_category' => 'S.B.C',
                  'slug' => 'sbc',
              ],
              [
                  'caste_category' => 'OtherState',
                  'slug' => 'other_state',
              ]
          ]);
    }
}
