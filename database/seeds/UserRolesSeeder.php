<?php
/**
 * Created by PhpStorm.
 * User: woxi
 * Date: 15/9/15
 * Time: 6:20 PM
 */
use Illuminate\Database\Seeder;

class UserRolesSeeder extends Seeder
{
    public function run(){
        DB::table('user_roles')->delete();

        $user_roles=array(
            array(
                'title'=>'Teacher',
                'slug'=>'teacher',
                'user_group_id'=>1
            ),
            array(
                'title'=>'Accountant',
                'slug'=>'accountant',
                'user_group_id'=>1
            ),
            array(
                'title'=>'Principal',
                'slug'=>'principal',
                'user_group_id'=>2
            ),
            array(
                'title'=>'Student',
                'slug'=>'student',
                'user_group_id'=>3
            ),
            array(
                'title'=>'Parent',
                'slug'=>'parent',
                'user_group_id'=>3
            )
        );

        DB::table('user_roles')->insert($user_roles);
    }
}