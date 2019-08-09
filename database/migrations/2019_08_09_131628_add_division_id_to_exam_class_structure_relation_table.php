<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDivisionIdToExamClassStructureRelationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exam_class_structure_relation', function (Blueprint $table) {
            $table->unsignedInteger('division_id')->nullable();
            $table->foreign('division_id')->references('id')->on('divisions')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exam_class_structure_relation', function (Blueprint $table) {
            $table->dropForeign('exam_class_structure_relation_division_id_foreign');
            $table->dropColumn('division_id');
        });
    }
}
