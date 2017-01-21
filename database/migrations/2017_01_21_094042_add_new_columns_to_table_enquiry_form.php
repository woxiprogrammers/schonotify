<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewColumnsToTableEnquiryForm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('enquiry_form', function (Blueprint $table) {
            $table->dateTime('written_test_scheduled_on')->nullable();
            $table->string('written_test_conducted_by',255)->nullable();
            $table->string('written_test_status',255)->nullable();
            $table->string('written_test_remark',255)->nullable();
            $table->dateTime('interview_scheduled_on')->nullable();
            $table->string('interview_conducted_by',255)->nullable();
            $table->string('interview_status',255)->nullable();
            $table->string('interview_remark',255)->nullable();
            $table->string('document_status',255)->nullable();
            $table->string('document_remark',255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('enquiry_form', function($table) {
            $table->dropColumn(['written_test_scheduled_on','written_test_conducted_by','written_test_status',
                                'written_test_remark','interview_scheduled_on','interview_conducted_by',
                                'interview_status','interview_remark','document_status','document_remark']);
        });
    }
}
