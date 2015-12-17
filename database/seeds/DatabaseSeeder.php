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
        $this->call(batchesTableSeeder::class);
        $this->call(ModuleSeeder::class);
        $this->call(UserRoleSeeder::class);
        $this->call(AttendanceTableSeeder::class);
        $this->call(DivisionSubjectTableSeeder::class);
        $this->call(ExamsTableSeeder::class);
        $this->call(ExamSubjectsTableSeeder::class);
        $this->call(ExamTypeTableSeeder::class);
        $this->call(MessagesTableSeeder::class);
        Model::reguard();
    }
}
