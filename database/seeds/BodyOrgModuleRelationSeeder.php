<?php
/**
 * Created by PhpStorm.
 * User: woxi
 * Date: 15/9/15
 * Time: 6:20 PM
 */
use Illuminate\Database\Seeder;

class BodyOrgModuleRelationSeeder extends Seeder
{
    public function run(){
        DB::table('body_org_module_relation')->delete();

        $arr=array(
            array(

                'body_org_id'=>1,
                'org_module_id'=>1
            ),
            array(

                'body_org_id'=>1,
                'org_module_id'=>2
            ),

            array(

                'body_org_id'=>1,
                'org_module_id'=>3
            ),
            array(

                'body_org_id'=>1,
                'org_module_id'=>4
            ),
            array(

                'body_org_id'=>2,
                'org_module_id'=>1
            ),
            array(

                'body_org_id'=>2,
                'org_module_id'=>2
            ),
            array(

                'body_org_id'=>2,
                'org_module_id'=>3
            )

        );

        DB::table('body_org_module_relation')->insert($arr);
    }
}