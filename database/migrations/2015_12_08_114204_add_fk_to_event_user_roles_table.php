<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkToEventUserRolesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_user_roles', function (Blueprint $table) {
            $table->foreign('event_id')
                ->references('id')
                ->on('events')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('user_role_id')
                ->references('id')
                ->on('user_roles')
                ->onUpdate('cascade')
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('event_user_roles', function (Blueprint $table) {
            $table->dropForeign('event_user_roles_event_id_foreign');
            $table->dropForeign('event_user_roles_user_role_id_foreign');
        });
    }
}
