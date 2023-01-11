<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('hotel_id');
            $table->integer('amount')->default(0);
            $table->float('area')->nullable();
            $table->integer('thumb_id')->nullable();
            $table->double('price', 14, 2)->default(0);
            $table->boolean('published')->default(false);
            $table->string('title')->default('');
            $table->integer('adults')->default(0);
            $table->integer('kids')->default(0);

            $table->timestamps();
        });
        Schema::create('media_room', function (Blueprint $table) {
            $table->integer('media_id');
            $table->integer('room_id');

            $table->foreign('media_id')->references('id')->on('media')->onDelete('cascade');
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
        });
        Schema::create('rooms_availabilities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('room_id');
            $table->date('date');
            $table->integer('amount');
            $table->boolean('available')->default(true);
            $table->integer('days_cancel')->nullable();
            $table->integer('days_book_min')->default(1);

            $table->decimal('price_special', 14, 2);
            $table->decimal('discount_percent', 14, 2)->default(0);

            $table->timestamps();

            $table->unique(['date', 'room_id']);
            $table->index(['room_id']);

        });
        Schema::create('option_room', function (Blueprint $table) {
            $table->integer('option_id');
            $table->integer('room_id');

            $table->string('value')->nullable();
            $table->double('price', 2, 14)->nullable();

            $table->foreign('option_id')->references('id')->on('options')->onDelete('cascade');
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('option_room');
        Schema::dropIfExists('rooms_availabilities');
        Schema::dropIfExists('media_room');
        Schema::dropIfExists('rooms');

    }
}
