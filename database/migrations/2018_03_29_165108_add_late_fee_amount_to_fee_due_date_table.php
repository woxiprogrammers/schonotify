<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLateFeeAmountToFeeDueDateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fee_due_date', function (Blueprint $table) {
            $table->integer('late_fee_amount')->default(0);
            $table->integer('number_of_days')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fee_due_date', function (Blueprint $table) {
            $table->dropColumn('late_fee_amount');
            $table->dropColumn('number_of_days');
        });
    }
}
