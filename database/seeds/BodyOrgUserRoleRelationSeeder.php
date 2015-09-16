<?php
/**
 * Created by PhpStorm.
 * User: woxi
 * Date: 15/9/15
 * Time: 6:20 PM
 */
use Illuminate\Database\Seeder;

class BodyOrgUserRoleRelationSeeder extends Seeder
{
    public function run(){
        DB::table('body_org_user_role_relation')->delete();

        $arr=array(
            array(

                'body_org_id'=>1,
                'org_user_role_id'=>1
            ),
            array(

                'body_org_id'=>1,
                'org_user_role_id'=>2
            ),

            array(

                'body_org_id'=>1,
                'org_user_role_id'=>3
            ),
            array(

                'body_org_id'=>1,
                'org_user_role_id'=>4
            ),
            array(

                'body_org_id'=>2,
                'org_user_role_id'=>1
            ),
            array(

                'body_org_id'=>2,
                'org_user_role_id'=>2
            ),
            array(

                'body_org_id'=>2,
                'org_user_role_id'=>3
            )

        );

        DB::table('body_org_user_role_relation')->insert($arr);
    }
}