<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTourBookingTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tour_bookings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id');
            $table->integer('tour_id');
            $table->integer('qty_adults')->default(0);
            $table->integer('qty_kids')->default(0);
            $table->integer('qty_additional')->default(0);

            $table->integer('food_option_id')->nullable();
            $table->double('food_option_cost', 14, 2)->nullable();

            $table->boolean('add_transfer')->default(false);
            $table->double('transfer_cost', 14, 2)->nullable();
            $table->boolean('add_flight')->default(false);
            $table->double('flight_cost', 14, 2)->nullable();

            $table->date('date_in');

            $table->double('sub_total', 14, 2)->default(0);
            $table->double('prepay', 14, 2)->default(0);
            $table->double('tax', 14, 2)->default(0);
            $table->double('total', 14, 2)->default(0);
            $table->string('currency_code');
            $table->integer('currency_id');
            $table->boolean('confirmed')->default(false);

            $table->text('notes')->default('')->nullable();

            $table->enum('status', ['created', 'confirmed', 'payed', 'canceled'])->default('created');

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
        Schema::dropIfExists('tour_bookings');
    }
}
