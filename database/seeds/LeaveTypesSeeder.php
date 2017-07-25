<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class LeaveTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('leave_types')->insert([
            [
                'name' => 'Full Day',
                'slug' =>'full day',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Half Day',
                'slug' =>'half day',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
    }
}
