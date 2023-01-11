<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('media', function (Blueprint $table) {
            $table->string('path')->nullable();
            $table->integer('model_id')->nullable();
            $table->string('model_type')->nullable();
            $table->string('path_high')->nullable();
            $table->string('url_high')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('media', function (Blueprint $table) {
            $table->dropColumn(['path', 'model_id', 'model_type', 'path_high', 'url_high']);
        });
    }
}
