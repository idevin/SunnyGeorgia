<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFoodOptionTranslations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tour_food_option_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('tour_food_option_id');
            $table->string('name');
            $table->string('locale')->index();

            $table->unique(['tour_food_option_id','locale']);
            $table->foreign('tour_food_option_id')->references('id')->on('tour_food_options')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tour_food_option_translations');
    }
}
