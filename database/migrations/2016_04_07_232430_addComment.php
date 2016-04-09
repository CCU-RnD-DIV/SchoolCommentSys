<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddComment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sid');
            $table->string('topic');
            $table->string('resp_text');
            $table->string('resp_expect');
            $table->string('resp_attachment');
            $table->dateTime('resp_time');

            $table->string('reply_text');
            $table->dateTime('reply_time');
            $table->string('reply_attachment');

            $table->string('reply_major');
            $table->integer('reply_OK');

            $table->integer('cancel');
            $table->dateTime('cancel_time');
            
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
        Schema::drop('comments');
    }
}
