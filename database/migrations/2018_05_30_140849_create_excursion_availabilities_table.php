<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExcursionAvailabilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('excursion_availabilities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('excursion_id');

            $table->date('date');
            $table->time('time');
            $table->integer('amount');

            $table->unique(['date', 'time', 'excursion_id']);

            $table->timestamps();
        });

        Schema::table('excursions', function (Blueprint $table) {
            $table->float('lat')->nullable();
            $table->float('long')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('excursion_availabilities');
        Schema::table('excursions', function (Blueprint $table) {
            $table->dropColumn('lat', 'long');
        });
    }
}
