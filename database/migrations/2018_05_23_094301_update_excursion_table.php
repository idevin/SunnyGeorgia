<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateExcursionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $curId = null;
        $res = DB::select('select id from currencies where code = \'GEL\';');
        $first = array_shift($res);
        if ($first) {
            $curId = $first->id;
        }

        Schema::table('excursions', function (Blueprint $table) use ($curId) {
            $table->string('start_place')->nullable();
            $table->json('start_time')->nullable();
            $table->integer('currency_id')->default($curId or 1);
            $table->double('price_kid', 14, 2)->nullable();
            $table->double('price_adult', 14, 2)->nullable();
            $table->double('price_excursion', 14, 2)->nullable();
            $table->string('route_length')->nullable();
        });

        DB::statement('update excursions set price_excursion = CASE price_per_person WHEN true THEN null ELSE price END;');
        DB::statement('update excursions set price_adult = CASE price_per_person WHEN true THEN price ELSE null END;');

        Schema::table('excursions', function (Blueprint $table) {
            $table->dropColumn('price', 'price_per_person', 'adults', 'children');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('excursions', function (Blueprint $table) {
            $table->double('price')->nullable();
            $table->boolean('price_per_person')->default(false);
            $table->integer('adults')->nullable();
            $table->integer('children')->nullable();
        });

        DB::statement('update excursions set price = CASE WHEN price_adult isnull THEN price_excursion ELSE price_adult END;');
        DB::statement('update excursions set price_per_person = CASE WHEN price_excursion isnull THEN false ELSE true END;');

        Schema::table('excursions', function (Blueprint $table) {
            $table->dropColumn(['start_place', 'start_time', 'currency_id', 'price_kid', 'price_adult', 'price_excursion']);
        });
    }
}
