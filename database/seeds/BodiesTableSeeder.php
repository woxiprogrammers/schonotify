<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class BodiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('bodies')->insert([
            [
                'name' => 'kothrud',
                'logo' => 'power-of-programmer3.jpeg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
            'name' => 'Karvenagar',
            'logo' => 'power-of-programmer3.jpeg',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
             ],
            [
                'name' => 'dahanukar',
                'logo' => 'power-of-programmer3.jpeg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ]);
    }
}
