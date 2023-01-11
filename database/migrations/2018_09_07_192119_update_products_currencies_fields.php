<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateProductsCurrenciesFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tours', function (Blueprint $table) {
            $table->dropColumn('transfer_currency', 'flight_currency');

            $table->string('currency_code')->nullable();
            $table->integer('currency_id')->nullable();
        });

        $tours = \App\Models\Tours\Tour::all()->load('accommodations', 'accommodations.currency');

        foreach ($tours as $tour) {
            foreach ($tour->accommodations as $accommodation) {
                $tour->currency_id = $accommodation->currency->id;
                $tour->currency_code = $accommodation->currency->code;
                $tour->save();
                echo '+';
            }
        }

        Schema::table('accommodations', function (Blueprint $table) {
//            $table->dropColumn('currency_id');
//            $table->string('currency_code')->nullable();

        });

        Schema::table('excursions', function (Blueprint $table) {
            $table->string('currency_code')->nullable();
        });
        $excursions = \App\Models\Excursions\Excursion::all()->load('currency');

        foreach ($excursions as $excursion) {
            $excursion->currency_code = $excursion->currency->code;
            $excursion->save();
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tours', function (Blueprint $table) {
            $table->dropColumn('currency_code', 'currency_id');

            $table->integer('flight_currency')->nullable();
            $table->integer('transfer_currency')->nullable();
        });
        Schema::table('accommodations', function (Blueprint $table) {
//            $table->integer('currency_id')->nullable();
//            $table->dropColumn('currency_code');
        });

        Schema::table('excursions', function (Blueprint $table) {
            $table->dropColumn('currency_code');
        });
    }
}
