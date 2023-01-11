<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExcursionBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('excursion_bookings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('excursion_id');
            $table->integer('excursion_availability_id');

            $table->integer('customer_id');

            $table->dateTime('date_time_in');
            $table->date('date_in');
            $table->time('time_in');
            $table->dateTime('date_out')->nullable();

            $table->integer('qty_adults')->default(0);
            $table->integer('qty_kids')->default(0);

            $table->double('sub_total', 14, 2)->default(0);
            $table->double('prepay', 14, 2)->default(0);
            $table->double('tax', 14, 2)->default(0);
            $table->double('total', 14, 2)->default(0);

            $table->string('currency_code');
            $table->integer('currency_id');

            $table->boolean('confirmed')->default(false);

            $table->text('customer_notes')->nullable();
            $table->text('partner_notes')->nullable();

            $table->boolean('price_changed')->default(false);

            $table->enum('status', ['created', 'confirmed', 'payed', 'canceled', 'rejected', 'pending'])->default('created');

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
        Schema::dropIfExists('excursion_bookings');
    }
}
