<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsCoScholasticToExamSubSubjectStructure extends Migration
{
    public function up()
    {
        Schema::table('exam_sub_subject_structure', function (Blueprint $table) {
            $table->boolean('is_co_scholastic')->nullable();
        });
    }

    public function down()
    {
        Schema::table('exam_sub_subject_structure', function (Blueprint $table) {
            $table->drop('exam_sub_subject_structure');
        });
    }
}
