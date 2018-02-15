<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFeeAdmissionIdToFeeAdmissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fee_admission', function (Blueprint $table) {
           $table->integer('fee_admission_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fee_admission', function (Blueprint $table) {
            $table->dropColumn('fee_admission_id');
        });
    }
}
