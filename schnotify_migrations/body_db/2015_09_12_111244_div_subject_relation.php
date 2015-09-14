<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DivSubjectRelation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('div_subject', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('div_id');
            $table->integer('teacher_id');
            $table->integer('subject_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('div_subject');
    }
}
