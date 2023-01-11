<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ExcursionExcursionTypePivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('excursion_excursion_type', function (Blueprint $table) {
            $table->unsignedInteger('excursion_id');
            $table->foreign('excursion_id')->references('id')->on('excursions')->onDelete('cascade');
            $table->unsignedInteger('excursion_type_id');
            $table->foreign('excursion_type_id')->references('id')->on('excursion_types')->onDelete('cascade');
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
