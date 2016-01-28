<?php

use Illuminate\Database\Schema\Blueprint;
 use Illuminate\Database\Migrations\Migration;

 class AddFKToEventImages extends Migration
 {
       /**
        * Run the migrations.
        *
        * @return void
        */
        public function up()
     {
                Schema::table('event_images', function (Blueprint $table) {
                        $table->foreign('event_id')
                            ->references('id')
                            ->on('events')
                           ->onUpdate('cascade');
         });
            }

     /**
      * Reverse the migrations.
      *
      * @return void
      */
     public function down()
     {
               Schema::table('event_images', function (Blueprint $table) {
                        $table->dropForeign('event_images_event_id_foreign');
                   });
           }
 }