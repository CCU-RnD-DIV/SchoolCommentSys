<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHashAtComment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::table('comments', function (Blueprint $table) {

            $table->dropColumn('reply_attachment');
            $table->dropColumn('resp_attachment');

        });

        Schema::table('comments', function (Blueprint $table) {

            $table->string('hash');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comments', function (Blueprint $table) {

            $table->dropColumn('hash');

        });
    }
}
