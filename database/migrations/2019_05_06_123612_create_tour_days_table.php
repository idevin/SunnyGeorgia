<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTourDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tour_days', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('day_order');
            $table->unsignedInteger('tour_id');
            $table->foreign('tour_id')->references('id')->on('tours')->onDalete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tour_days');
    }
}
