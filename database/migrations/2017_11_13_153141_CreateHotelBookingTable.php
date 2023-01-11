<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHotelBookingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel_bookings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('hotel_id');
            $table->integer('user_id');
            $table->date('date_in');
            $table->date('date_out');
//            $table->integer('amount')->default(0);
//            $table->float('area')->nullable();
//            $table->integer('thumb_id');
            $table->double('tax_total', 14, 2)->default(0);
            $table->double('price_total', 14, 2)->default(0);
//            $table->boolean('published');
//            $table->string('title')->default('');
//            $table->integer('adults')->default(0);
            $table->text('notes')->default('');

            $table->index(['date_in','date_out']);

            $table->timestamps();
        });
        Schema::create('room_bookings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('hotel_booking_id');
            $table->integer('hotel_id');
            $table->integer('room_id');
            $table->integer('amount');

            //????

//            $table->date('date_in');
//            $table->date('date_out');


//            $table->integer('user_id');
//            $table->integer('amount')->default(0);
//            $table->float('area')->nullable();
//            $table->integer('thumb_id');
            $table->double('price_total', 14, 2)->default(0);
            $table->double('tax_total', 14, 2)->default(0);

            $table->text('notes')->default('');

//            $table->boolean('published');
//            $table->string('title')->default('');
//            $table->integer('adults')->default(0);
//            $table->integer('kids')->default(0);
            $table->index(['hotel_booking_id']);

            $table->timestamps();
        });

        Schema::create('hotel_booking_guests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('hotel_booking_id');
            $table->integer('room_booking_id');
            $table->string('first_name')->default('');
            $table->string('last_name')->default('');
            $table->boolean('child')->default(false);
            $table->integer('age')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hotel_booking_guests');
        Schema::dropIfExists('room_bookings');
        Schema::dropIfExists('hotel_bookings');

    }
}
