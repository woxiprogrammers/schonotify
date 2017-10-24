<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExamTypeToStudentExamMarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('student_exam_marks', function (Blueprint $table) {
            $table->unsignedInteger('exam_term_details_id');
            $table->foreign('exam_term_details_id')
                ->references('id')
                ->on('exam_term_details')
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
        Schema::table('student_exam_marks', function (Blueprint $table) {
            $table->dropColumn('exam_term_details_id');
        });
    }
}
