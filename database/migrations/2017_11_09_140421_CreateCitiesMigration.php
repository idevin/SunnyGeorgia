<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitiesMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('places', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('places_group_id')->unsigned()->nullable();
            $table->integer('image_id')->nullable();
            $table->string('slug')->nullable();
            $table->boolean('published')->default(true);
            $table->timestamps();
        });
        Schema::create('media_place', function (Blueprint $table) {
            $table->integer('media_id');
            $table->integer('place_id');

            $table->foreign('media_id')->references('id')->on('media')->onDelete('cascade');
            $table->foreign('place_id')->references('id')->on('places')->onDelete('cascade');
        });

        Schema::create('place_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('place_id')->unsigned();
            $table->string('locale', 10)->index();
            $table->string('name')->nullable();
            $table->string('keywords')->nullable();
            $table->text('page')->nullable();

            $table->unique(['place_id', 'locale']);
            $table->foreign('place_id')->references('id')->on('places')->onDelete('cascade');
        });

        Schema::create('places_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->nullable();
            $table->timestamps();
        });

        Schema::create('places_group_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('places_group_id')->unsigned();
            $table->string('locale', 10)->index();
            $table->string('name');

            $table->unique(['places_group_id', 'locale']);
            $table->foreign('places_group_id')->references('id')->on('places_groups')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('places_group_translations');
        Schema::dropIfExists('places_groups');
        Schema::dropIfExists('place_translations');
        Schema::dropIfExists('media_place');
        Schema::dropIfExists('places');
    }
}
