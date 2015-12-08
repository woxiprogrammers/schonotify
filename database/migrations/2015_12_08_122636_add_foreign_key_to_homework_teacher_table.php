<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyToHomeworkTeacherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('homework_teacher', function (Blueprint $table) {
            $table->foreign('student_id')
                ->references('id')
                ->on('students')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('homework_id')
                ->references('id')
                ->on('homeworks')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('teacher_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('division_id')
                ->references('id')
                ->on('divisions')
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
        Schema::table('homework_teacher', function (Blueprint $table) {
            $table->dropForeign('homework_teacher_student_id_foreign');
            $table->dropForeign('homework_teacher_homework_id_foreign');
            $table->dropForeign('homework_teacher_teacher_id_foreign');
            $table->dropForeign('homework_teacher_division_id_foreign');
        });
    }
}
