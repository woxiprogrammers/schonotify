<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyToHomeworksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('homeworks', function (Blueprint $table) {
            $table->foreign('homework_type_id')
                ->references('id')
                ->on('homework_types')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('subject_id')
                ->references('id')
                ->on('subjects')
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
        Schema::table('homeworks', function (Blueprint $table) {
            $table->dropForeign('homeworks_homework_type_id_foreign');
            $table->dropForeign('homeworks_subject_id_foreign');
        });
    }
}
