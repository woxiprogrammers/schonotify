<?php
/**
 * Created by PhpStorm.
 * User: woxi
 * Date: 15/9/15
 * Time: 6:20 PM
 */
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class OrganizationUsersSeeder extends Seeder
{
    public function run(){
        DB::table('org_users')->delete();

        $org_users=array(
            array(

                'username'=>'suraj',
                'email'=>'suraj.woxi@gmail.com',
                'password'=>Hash::make('admin'),
                'mobile'=>9766546049,
                'org_id'=>1,
                'is_active'=>1
            ),
            array(

                'username'=>'sagar',
                'email'=>'sagar.woxi@gmail.com',
                'password'=>Hash::make('admin'),
                'mobile'=>9766546049,
                'org_id'=>1,
                'is_active'=>1
            )
        );

        DB::table('org_users')->insert($org_users);
    }
}