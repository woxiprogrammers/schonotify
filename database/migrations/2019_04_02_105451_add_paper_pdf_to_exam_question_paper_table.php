<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPaperPdfToExamQuestionPaperTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exam_question_paper', function (Blueprint $table) {
            $table->string('paper_pdf',255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exam_question_paper', function (Blueprint $table) {
            $table->dropColumn('paper_pdf');
        });
    }
}
