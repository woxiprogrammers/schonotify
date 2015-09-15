<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BodyOrgUserRoleRelation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('body_org_user_role_relation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('body_org_id');
            $table->integer('org_user_role_id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('body_org_user_role_relation');
    }
}
