<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkToModuleAclTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('module_acls', function (Blueprint $table) {

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade');

            $table->foreign('module_id')
                ->references('id')
                ->on('modules')
                ->onUpdate('cascade');

            $table->foreign('acl_id')
                ->references('id')
                ->on('acl_master')
                ->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('module_acls', function (Blueprint $table) {
            $table->dropForeign('module_acls_user_id_foreign');
            $table->dropForeign('module_acls_module_id_foreign');
            $table->dropForeign('module_acls_acl_id_foreign');
        });
    }

}
