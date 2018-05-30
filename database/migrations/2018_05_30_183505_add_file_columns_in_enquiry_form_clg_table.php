<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFileColumnsInEnquiryFormClgTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('enquiry_form_clg', function (Blueprint $table) {
            $table->string('ssc_certificate',512)->nullable();
            $table->string('hsc_certificate',512)->nullable();
            $table->string('caste_certificate',512)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('enquiry_form_clg', function (Blueprint $table) {
            $table->dropColumn('ssc_certificate');
            $table->dropColumn('hsc_certificate');
            $table->dropColumn('caste_certificate');
        });
    }
}
