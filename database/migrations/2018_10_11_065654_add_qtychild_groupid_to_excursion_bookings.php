<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddQtychildGroupidToExcursionBookings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('excursion_bookings', function (Blueprint $table) {
            $table->integer('group_pid')->nullable()->after('qty_kids');
            $table->integer('qty_baby')->default(0)->after('qty_kids');
            $table->integer('qty_child')->default(0)->after('qty_kids');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('excursion_bookings', function (Blueprint $table) {
            $table->dropColumn('qty_child');
            $table->dropColumn('qty_baby');
            $table->dropColumn('group_pid');
        });
    }
}
