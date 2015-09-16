<?php
/**
 * Created by PhpStorm.
 * User: woxi
 * Date: 15/9/15
 * Time: 6:20 PM
 */
use Illuminate\Database\Seeder;

class UserGroupsSeeder extends Seeder
{
    public function run(){
        DB::table('user_groups')->delete();

        $user_group=array(
            array(

                'name'=>'Teacher',
                'slug'=>'teacher'
            ),
            array(

                'name'=>'Admin',
                'slug'=>'admin'
            ),
            array(

                'name'=>'Parent',
                'slug'=>'parent'
            )
        );

        DB::table('user_groups')->insert($user_group);
    }
}