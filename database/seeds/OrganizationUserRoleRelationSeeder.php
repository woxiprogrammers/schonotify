<?php
/**
 * Created by PhpStorm.
 * User: woxi
 * Date: 15/9/15
 * Time: 6:20 PM
 */
use Illuminate\Database\Seeder;

class OrganizationUserRoleRelationSeeder extends Seeder
{
    public function run(){
        DB::table('org_user_role_relation')->delete();

        $arr=array(
            array(

                'org_id'=>1,
                'user_role_id'=>1
            ),
            array(

                'org_id'=>1,
                'user_role_id'=>2
            ),

            array(

                'org_id'=>1,
                'user_role_id'=>3
            ),
            array(

                'org_id'=>1,
                'user_role_id'=>4
            ),
            array(

                'org_id'=>1,
                'user_role_id'=>5
            )

        );

        DB::table('org_user_role_relation')->insert($arr);
    }
}