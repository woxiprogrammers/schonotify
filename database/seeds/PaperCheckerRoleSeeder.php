<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;


class PaperCheckerRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('paper_checker_master')->insert([
            [
                'name' => 'Teacher',
                'slug' => 'teacher',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Moderator',
                'slug' => 'moderator',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
    }
}
