<?php
/**
 * Created by PhpStorm.
 * User: woxi
 * Date: 15/9/15
 * Time: 6:20 PM
 */
use Illuminate\Database\Seeder;

class OrganizationModuleRelationSeeder extends Seeder
{
    public function run(){
        DB::table('org_module_relation')->delete();

        $arr=array(
            array(

                'org_id'=>1,
                'module_id'=>1
            ),
            array(

                'org_id'=>1,
                'module_id'=>2
            ),

            array(

                'org_id'=>1,
                'module_id'=>3
            ),
            array(

                'org_id'=>1,
                'module_id'=>4
            ),
            array(

                'org_id'=>1,
                'module_id'=>5
            ),
            array(

                'org_id'=>1,
                'module_id'=>6
            )

        );

        DB::table('org_module_relation')->insert($arr);
    }
}