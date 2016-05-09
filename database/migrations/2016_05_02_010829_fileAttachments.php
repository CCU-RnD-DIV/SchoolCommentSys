<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FileAttachments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fileAttachment', function (Blueprint $table) {
            $table->increments('id');
            $table->string('comments_id');
            $table->string('attachment');
            $table->integer('attachment_type');
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
        Schema::drop('fileAttachment');
        Schema::table('comments', function (Blueprint $table) {

            $table->dropColumn('reply_attachment');
            $table->dropColumn('resp_attachment');

        });
    }
}
