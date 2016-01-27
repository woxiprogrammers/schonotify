<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyToExamSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exam_subjects', function (Blueprint $table) {
            $table->foreign('exam_id')
                ->references('id')
                ->on('exams')
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
        Schema::table('exam_subjects', function (Blueprint $table) {
            $table->dropForeign('exam_subjects_exam_id_foreign');
            $table->dropForeign('exam_subjects_subject_id_foreign');
        });
    }
}
