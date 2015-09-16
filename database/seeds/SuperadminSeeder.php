<?php
/**
 * Created by PhpStorm.
 * User: woxi
 * Date: 15/9/15
 * Time: 6:20 PM
 */
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperadminSeeder extends Seeder
{
    public function run(){
        DB::table('superadmin')->delete();

        $org=array(
            array(

                'username'=>'suraj',
                'email'=>'suraj.woxi@gmail.com',
                'password'=>Hash::make('password'),
                'mobile'=>9766546049,
                'is_active'=>1
            )
        );

        DB::table('superadmin')->insert($org);
    }
}