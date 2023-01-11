<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTransactionColumnToTourBooking extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tour_bookings', function (Blueprint $table) {
            $table->decimal('transaction_fee', 14, 2)->default(0);
            $table->decimal('sub_total', 14, 2)->default(0)->change();
            $table->decimal('prepay', 14, 2)->default(0)->change();
            $table->decimal('tax', 14, 2)->default(0)->change();
            $table->decimal('total', 14, 2)->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
