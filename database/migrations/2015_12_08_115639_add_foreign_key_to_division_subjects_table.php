<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyToDivisionSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('division_subjects', function (Blueprint $table) {
            $table->foreign('division_id')
                ->references('id')
                ->on('divisions')
                ->onUpdate('cascade');
            $table->foreign('teacher_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade');
            $table->foreign('subject_id')
                ->references('id')
                ->on('subjects')
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
        Schema::table('division_subjects', function (Blueprint $table) {
            $table->dropForeign('division_subjects_division_id_foreign');
            $table->dropForeign('division_subjects_teacher_id_foreign');
            $table->dropForeign('division_subjects_subject_id_foreign');
        });
    }
}
