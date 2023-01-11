<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHotlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotels', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('place_id');
            $table->integer('thumb_id')->nullable();
            $table->double('price')->nullable();
            $table->boolean('published')->default(false);
            $table->string('type')->nullable();
            $table->string('address')->nullable();
            $table->string('in_time', 30)->nullable();
            $table->string('out_time', 30)->nullable();
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->string('slug')->unique()->nullable();

            $table->timestamps();
        });

        Schema::create('hotel_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('hotel_id')->unsigned();
            $table->string('locale', 10)->index();
            $table->string('title');
            $table->text('intro');
            $table->text('description');

            $table->unique(['hotel_id', 'locale']);
            $table->foreign('hotel_id')->references('id')->on('hotels')->onDelete('cascade');
        });

        Schema::create('hotel_media', function (Blueprint $table) {
            $table->integer('media_id');
            $table->integer('hotel_id');

            $table->foreign('media_id')->references('id')->on('media')->onDelete('cascade');
            $table->foreign('hotel_id')->references('id')->on('hotels')->onDelete('cascade');
        });


        Schema::create('hotel_option', function (Blueprint $table) {
            $table->integer('option_id');
            $table->integer('hotel_id');

            $table->string('value')->nullable();
            $table->double('price', 2, 14)->nullable();

            $table->foreign('option_id')->references('id')->on('options')->onDelete('cascade');
            $table->foreign('hotel_id')->references('id')->on('hotels')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hotel_option');
        Schema::dropIfExists('hotel_media');
        Schema::dropIfExists('hotel_translations');
        Schema::dropIfExists('hotels');
    }
}
