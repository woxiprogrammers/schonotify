<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('role_id')->unsigned();
            $table->string('username',255);
            $table->integer('body_id')->unsigned();
            $table->string('first_name',255);
            $table->string('last_name',255);
            $table->string('email',255);
            $table->string('gender',10);
            $table->date('birth_date');
            $table->string('mobile')->nullable();
            $table->string('password',255);
            $table->text('address');
            $table->string('alternate_number');
            $table->integer('parent_id');
            $table->integer('roll_number');
            $table->string('emp_type',255);
            $table->integer('division_id')->unsigned()->nullable();
            $table->boolean('is_active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
