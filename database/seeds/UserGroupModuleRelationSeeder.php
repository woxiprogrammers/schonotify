<?php
/**
 * Created by PhpStorm.
 * User: woxi
 * Date: 15/9/15
 * Time: 6:20 PM
 */
use Illuminate\Database\Seeder;

class UserGroupModuleRelationSeeder extends Seeder
{
    public function run(){
        DB::table('user_group_module_relation')->delete();

        $arr=array(
            array(

                'master_module_id'=>1,
                'user_group_id'=>1
            ),
            array(

                'master_module_id'=>1,
                'user_group_id'=>2
            ),
            array(

                'master_module_id'=>1,
                'user_group_id'=>3
            ),

            array(

                'master_module_id'=>3,
                'user_group_id'=>1
            ),
            array(

                'master_module_id'=>3,
                'user_group_id'=>2
            ),
            array(

                'master_module_id'=>3,
                'user_group_id'=>3
            ),
            array(

                'master_module_id'=>4,
                'user_group_id'=>1
            ),
            array(

                'master_module_id'=>4,
                'user_group_id'=>2
            ),
            array(

                'master_module_id'=>4,
                'user_group_id'=>3
            ),
            array(

                'master_module_id'=>5,
                'user_group_id'=>1
            ),
            array(

                'master_module_id'=>5,
                'user_group_id'=>2
            ),
            array(

                'master_module_id'=>5,
                'user_group_id'=>3
            ),
            array(

                'master_module_id'=>6,
                'user_group_id'=>1
            ),
            array(

                'master_module_id'=>6,
                'user_group_id'=>2
            ),
            array(

                'master_module_id'=>6,
                'user_group_id'=>3
            ),
        );

        DB::table('user_group_module_relation')->insert($arr);
    }
}