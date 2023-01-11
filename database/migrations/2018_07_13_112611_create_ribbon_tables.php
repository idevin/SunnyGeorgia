<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRibbonTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ribbons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type')->nullable();
            $table->timestamps();
        });
        Schema::create('ribbon_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ribbon_id');
            $table->string('locale', 10);
            $table->string('title');
            $table->timestamps();
        });
        Schema::create('ribands', function (Blueprint $table) {
            $table->integer('ribbon_id');
            $table->morphs('riband');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ribbons');
        Schema::dropIfExists('ribbon_translations');
        Schema::dropIfExists('ribands');
    }
}
