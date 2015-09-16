<?php
/**
 * Created by PhpStorm.
 * User: woxi
 * Date: 15/9/15
 * Time: 6:20 PM
 */
use Illuminate\Database\Seeder;

class BodyOrganizationRelationSeeder extends Seeder
{
    public function run(){
        DB::table('body_org_relation')->delete();

        $arr=array(
            array(
                'org_id'=>1,
                'body_type_id'=>1,
                'name'=>'Kothrud',
                'slug'=>'kothrud'
            ),
            array(
                'org_id'=>1,
                'body_type_id'=>1,
                'name'=>'Aundh',
                'slug'=>'aundh'
            ),
            array(
                'org_id'=>1,
                'body_type_id'=>1,
                'name'=>'Sanghvi',
                'slug'=>'sanghvi'
            )
        );
        DB::table('body_org_relation')->insert($arr);
    }
}