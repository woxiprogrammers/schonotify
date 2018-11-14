<?php

use Illuminate\Database\Seeder;
use \Carbon\Carbon;

class SocialPlatformSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('social_platform')->insert([
            [
                'name' => 'Facebook',
                'slug'=>'facebook',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'LinkedIn',
                'slug'=>'linked-in',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Google+',
                'slug'=>'google',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Twitter',
                'slug'=>'twitter',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Instagram',
                'slug'=>'instagram',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Youtube',
                'slug'=>'youtube',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ]);
    }
}
