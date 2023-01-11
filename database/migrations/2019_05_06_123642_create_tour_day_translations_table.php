<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTourDayTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tour_day_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('tour_day_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->string('title');
            $table->text('description');
            $table->unique(['tour_day_id','locale']);
            $table->foreign('tour_day_id')->references('id')->on('tour_days')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tour_day_translations');
    }
}
