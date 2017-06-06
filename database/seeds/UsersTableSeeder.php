<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;


    class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'role_id' => '1',
                'username' => 'adminNew',
                'body_id' => '1',
                'first_name' => 'AdminF',
                'last_name' => 'AdminL',
                'email' => 'admin@gmail.com',
                'gender' => 'M',
                'birth_date' => '2016-01-27 00:00:00',
                'mobile' => '1234567890',
                'password' => bcrypt('123456'),
                'address' => 'maharashtra Pune',
                'alternate_number' => '',
                'avatar' => 'default-user.jpg',
                'parent_id' => '0',
                'roll_number' => '0',
                'emp_type' => 'full_type',
                'division_id' => NULL,
                'is_active' => 1,
                'remember_token' => 'jznsnrBykw4NpyabN14uRVGFFXLsjqt3c87ZuwBSzoEehA87RTiZDKRLfX3F',
                'confirmation_code' => str_random(30),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);

    }
}
