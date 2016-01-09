<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class batchesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('batches')->insert([
            [
                'name' => 'morning',
                'description'=>'morning batch',
                'slug' =>'morning',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'afternoon',
                'description'=>'afternoon batch',
                'slug' =>'afternoon',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],

        ]);
    }
}
