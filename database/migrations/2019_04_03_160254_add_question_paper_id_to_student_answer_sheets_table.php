<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddQuestionPaperIdToStudentAnswerSheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('student_answer_sheets', function (Blueprint $table) {
            $table->unsignedInteger('question_paper_id')->nullable();
            $table->foreign('question_paper_id')->references('id')->on('exam_question_paper')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('student_answer_sheets', function (Blueprint $table) {
            $table->dropForeign('student_answer_sheets_question_paper_id_foreign');
            $table->dropColumn('question_paper_id');
        });
    }
}
