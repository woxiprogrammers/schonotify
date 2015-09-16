<?php
/**
 * Created by PhpStorm.
 * User: woxi
 * Date: 15/9/15
 * Time: 6:20 PM
 */
use Illuminate\Database\Seeder;

class OrganizationSeeder extends Seeder
{
    public function run(){
        DB::table('organization')->delete();

        $org=array(
            array(

                'name'=>'mit',
                'city'=>'pune',
                'state'=>'maharashtra',
                'country'=>'india',
                'url'=>'mit.schnotify.com',
                'slug'=>'mit',
                'is_active'=>1
            )
        );

        DB::table('organization')->insert($org);
    }
}