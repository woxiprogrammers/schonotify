<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkToMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->foreign('from_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade');


            $table->foreign('to_id')
                ->references('id')
                ->on('users')
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
        Schema::table('messages', function (Blueprint $table) {
            $table->dropForeign('messages_from_id_foreign');
            $table->dropForeign('messages_to_id_foreign');
        });
    }
}
