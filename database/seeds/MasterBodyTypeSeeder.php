<?php
/**
 * Created by PhpStorm.
 * User: woxi
 * Date: 15/9/15
 * Time: 6:20 PM
 */
use Illuminate\Database\Seeder;

class MasterBodyTypeSeeder extends Seeder
{
    public function run(){
        DB::table('master_body_type')->delete();

        $arr=array(
            array(

                'name'=>'School',
                'slug'=>'school'
            ),
            array(

                'name'=>'College',
                'slug'=>'college'
            ),
            array(

                'name'=>'University',
                'slug'=>'university'
            ),
            array(

                'name'=>'Academy',
                'slug'=>'academy'
            )
        );

        DB::table('master_body_type')->insert($arr);
    }
}