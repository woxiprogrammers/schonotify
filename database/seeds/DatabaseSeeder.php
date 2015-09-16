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

        $this->call('OrganizationSeeder');
        $this->call('BodyOrganizationRelationSeeder');
        $this->call('BodyOrgModuleRelationSeeder');
        $this->call('BodyOrgUserRoleRelationSeeder');
        $this->call('MasterBodyTypeSeeder');
        $this->call('MasterModulesSeeder');
        $this->call('OrganizationModuleRelationSeeder');
        $this->call('OrganizationUserRoleRelationSeeder');
        $this->call('OrganizationUsersSeeder');
        $this->call('UserGroupModuleRelationSeeder');
        $this->call('UserGroupsSeeder');
        $this->call('UserRolesSeeder');
        $this->call('SuperadminSeeder');


        Model::reguard();
    }
}
