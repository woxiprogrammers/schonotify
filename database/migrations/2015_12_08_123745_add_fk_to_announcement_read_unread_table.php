<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkToAnnouncementReadUnreadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('announcement_read_unread', function (Blueprint $table) {
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('event_id')
                ->references('id')
                ->on('events')
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
        Schema::table('announcement_read_unread', function (Blueprint $table) {
            $table->dropForeign('announcement_read_unread_user_id_foreign');
            $table->dropForeign('announcement_read_unread_event_id_foreign');
        });
    }
}
