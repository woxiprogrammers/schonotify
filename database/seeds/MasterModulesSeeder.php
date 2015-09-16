<?php
/**
 * Created by PhpStorm.
 * User: woxi
 * Date: 15/9/15
 * Time: 6:20 PM
 */
use Illuminate\Database\Seeder;

class MasterModulesSeeder extends Seeder
{
    public function run(){
        DB::table('master_modules')->delete();

        $master_modules=array(
            array(

                'name'=>'Exam',
                'slug'=>'exam'
            ),

            array(

                'name'=>'Timetable',
                'slug'=>'timetable'
            ),
            array(

                'name'=>'Events',
                'slug'=>'events'
            ),
            array(

                'name'=>'Results',
                'slug'=>'results'
            ),
            array(

                'name'=>'Attendance',
                'slug'=>'attendance'
            ),
            array(

                'name'=>'Homework',
                'slug'=>'homework'
            )
        );

        DB::table('master_modules')->insert($master_modules);
    }
}