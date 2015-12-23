<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class MessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('messages')->insert([
            [
                'description' => 'Hi',
                'from_id' => 15,
                'to_id' => 19,
                'timestamp' => Carbon::now(),
                'read_status' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'description' => 'Hello',
                'from_id' => 19,
                'to_id' => 15,
                'timestamp' => Carbon::now(),
                'read_status' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()

            ],
            [
                'description' => 'How r u?',
                'from_id' => 15,
                'to_id' => 19,
                'timestamp' => Carbon::now(),
                'read_status' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()

            ],
            [
                'description' => 'Fine',
                'from_id' => 19,
                'to_id' => 15,
                'timestamp' => Carbon::now(),
                'read_status' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'description' => 'Hi',
                'from_id' => 15,
                'to_id' => 16,
                'timestamp' => Carbon::now(),
                'read_status' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'description' => 'Good morning',
                'from_id' => 16,
                'to_id' => 15,
                'timestamp' => Carbon::now(),
                'read_status' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'description' => 'Where r u?',
                'from_id' => 16,
                'to_id' => 10,
                'timestamp' => Carbon::now(),
                'read_status' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
    }
}
