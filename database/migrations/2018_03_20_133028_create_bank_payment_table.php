<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('system'); //GeoPay, TBC, PayPal, other
            $table->string('transaction_id');
            $table->integer('amount');

            $table->integer('currency_id');
            $table->string('currency_code');
            $table->string('status');
            $table->json('data')->nullable();

            $table->integer('user_id');//tourBooking, hotelBooking, excursionBooking, other service
            $table->integer('service_id');//tourBooking, hotelBooking, excursionBooking, other service
            $table->string('service_type');//tourBooking, hotelBooking, excursionBooking, other service

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
        Schema::dropIfExists('bank_payments');
    }
}
