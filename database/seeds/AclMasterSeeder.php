<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;


class AclMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('acl_master')->insert([
            [
                'title' => 'Create',
                'slug' => 'create',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'Delete',
                'slug' => 'delete',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()

            ],
            [
                'title' => 'Update',
                'slug' => 'update',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'View',
                'slug' => 'view',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'Publish',
                'slug' => 'publish',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
    }
}
