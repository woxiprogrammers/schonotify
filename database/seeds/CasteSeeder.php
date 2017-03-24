<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CasteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('caste')->insert([
            [
                'slug' => 'sc',
                'caste_name'=>'SC',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'slug' => 'nt',
                'caste_name'=>'NT',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'slug' => 'obc',
                'caste_name'=>'OBC',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'slug' => 'open',
                'caste_name'=>'OPEN',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ]);
    }
}
