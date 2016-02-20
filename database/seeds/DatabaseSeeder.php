<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $this->call(AclMasterSeeder::class);
        $this->call(EventTypesSeeder::class);
        $this->call(HomeworkTypesTableSeeder::class);
        $this->call(BodiesTableSeeder::class);
        $this->call(ModuleSeeder::class);
        $this->call(UserRoleSeeder::class);
        $this->call(ExamTypeTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(ModulesAclsTableSeeder::class);
        $this->call(DayTableSeeder::class);
        $this->call(LeaveTypesSeeder::class);

        Model::reguard();
    }
}
