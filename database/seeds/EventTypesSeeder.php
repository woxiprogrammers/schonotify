<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class EventTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('event_types')->insert([
            [
                'event_name' => 'Announcement',
                'slug' => 'announcement',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [

                'event_name' => 'Achievement',
                'slug' => 'achievement',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'event_name' => 'Event',
                'slug' => 'event',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
    }
}
