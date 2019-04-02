<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsExamEvaluationToExamTermDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exam_term_details', function (Blueprint $table) {
            $table->boolean('is_exam_evaluation')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exam_term_details', function (Blueprint $table) {
            $table->dropColumn('is_exam_evaluation');
        });
    }
}
