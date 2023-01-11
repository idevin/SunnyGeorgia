<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateToursTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tours', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('start_place_id')->nullable();
            $table->integer('thumb_id')->nullable();

            $table->double('price')->nullable();
            $table->boolean('price_per_person')->default(false);

            $table->boolean('published')->default(false);
            $table->boolean('calendar_use')->default(false);

            $table->boolean('flight_included')->default(false);
            $table->double('flight_price', 14, 2)->nullable();
            $table->integer('flight_currency')->nullable();

            $table->boolean('transfer_included')->default(false);
            $table->double('transfer_price', 14, 2)->nullable();
            $table->integer('transfer_currency')->nullable();

            $table->integer('min_people')->default(0);
            $table->integer('max_people')->nullable();

            $table->integer('free_cancel_before')->default(0);
            $table->integer('days')->default(0);
            $table->integer('nights')->default(0);

            $table->integer('adults')->nullable();
            $table->integer('children')->nullable();

            $table->string('slug')->unique()->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('place_tour', function (Blueprint $table) {
            $table->integer('place_id');
            $table->integer('tour_id');

            $table->index(['tour_id']);

            $table->foreign('place_id')->references('id')->on('places')->onDelete('cascade');
            $table->foreign('tour_id')->references('id')->on('tours')->onDelete('cascade');
        });

        Schema::create('tour_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tour_id')->unsigned();
            $table->string('locale', 10)->index();
            $table->string('title')->nullable();
            $table->text('intro')->nullable();
            $table->text('description')->nullable();
//            $table->text('meta_title');
//            $table->text('meta_keywords');
//            $table->text('meta_description');

            $table->unique(['tour_id', 'locale']);
            $table->foreign('tour_id')->references('id')->on('tours')->onDelete('cascade');
        });
        Schema::create('option_tour', function (Blueprint $table) {
            $table->integer('option_id');
            $table->integer('tour_id');

            $table->boolean('free')->default(true);
            $table->string('value')->nullable();
            $table->double('price', 2, 14)->nullable();

            $table->foreign('option_id')->references('id')->on('options')->onDelete('cascade');
            $table->foreign('tour_id')->references('id')->on('tours')->onDelete('cascade');
        });

        Schema::create('media_tour', function (Blueprint $table) {
            $table->integer('media_id');
            $table->integer('tour_id');

            $table->foreign('media_id')->references('id')->on('media')->onDelete('cascade');
            $table->foreign('tour_id')->references('id')->on('tours')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('media_tour');
        Schema::dropIfExists('option_tour');
        Schema::dropIfExists('tour_translations');
        Schema::dropIfExists('place_tour');
        Schema::dropIfExists('tours');
    }
}
