<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class BatchesTableSeeder extends Seeder
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
                'name' => 'Morning',
                'description' => 'morning batch',
                'slug'=>'morning',
                'body_id'=>1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Afternoon',
                'description' => 'afternoon batch',
                'slug'=>'afternoon',
                'body_id'=>1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Evening',
                'description' => 'evening batch',
                'slug'=>'evening',
                'body_id'=>1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ]);
    }
}
