<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExcursionTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('excursions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('place_id');
            $table->integer('thumb_id')->nullable();
            $table->double('price')->nullable();
            $table->boolean('price_per_person')->default(false);
            $table->boolean('published')->default(false);
            $table->boolean('calendar_use')->default(false);
            $table->double('duration')->nullable();

            $table->integer('min_people')->default(0);
            $table->integer('max_people')->nullable();

            $table->integer('adults')->nullable();
            $table->integer('children')->nullable();

            $table->integer('free_cancel_before')->default(0);

            $table->string('slug')->unique()->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('excursion_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('excursion_id')->unsigned();
            $table->string('locale', 10)->index();
            $table->string('title')->nullable();
            $table->text('intro')->nullable();
            $table->text('description')->nullable();
//            $table->text('meta_title');
//            $table->text('meta_keywords');
//            $table->text('meta_description');

            $table->unique(['excursion_id', 'locale']);
            $table->foreign('excursion_id')->references('id')->on('excursions')->onDelete('cascade');
        });
        Schema::create('excursion_option', function (Blueprint $table) {
            $table->integer('option_id');
            $table->integer('excursion_id');

            $table->string('value')->nullable();
            $table->double('price', 2, 14)->nullable();
            $table->boolean('free')->default(true);

            $table->foreign('option_id')->references('id')->on('options')->onDelete('cascade');
            $table->foreign('excursion_id')->references('id')->on('excursions')->onDelete('cascade');
        });

        Schema::create('excursion_media', function (Blueprint $table) {
            $table->integer('media_id');
            $table->integer('excursion_id');

            $table->foreign('media_id')->references('id')->on('media')->onDelete('cascade');
            $table->foreign('excursion_id')->references('id')->on('excursions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('excursion_media');
        Schema::dropIfExists('excursion_option');
        Schema::dropIfExists('excursion_translations');
        Schema::dropIfExists('excursions');
    }
}
