<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FileDescription extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fileAttachment', function (Blueprint $table) {

            $table->string('file_des');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('fileAttachment', function (Blueprint $table) {

            $table->dropColumn('file_des');
            
        });

    }
}
