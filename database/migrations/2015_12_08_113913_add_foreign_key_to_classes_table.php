<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyToClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('classes', function (Blueprint $table) {
            $table->foreign('body_id')
                ->references('id')
                ->on('bodies')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('batch_id')
                ->references('id')
                ->on('batches')
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
        Schema::table('classes', function (Blueprint $table) {
            $table->dropForeign('classes_body_id_foreign');
            $table->dropForeign('classes_batch_id_foreign');
        });
    }
}
