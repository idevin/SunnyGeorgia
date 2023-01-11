<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ExcursionManyStartplaces extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('excursion_place', function (Blueprint $table) {
        $table->unsignedInteger('excursion_id');
        $table->foreign('excursion_id')->references('id')->on('excursions')->onDelete('cascade');
        $table->unsignedInteger('place_id');
        $table->foreign('place_id')->references('id')->on('places')->onDelete('cascade');
      });

      $excursions = \App\Models\Excursions\Excursion::all();
      foreach ($excursions as $excursion) {
        if(isset($excursion->place_id) && $excursion->place_id !== 0) {
          $excursion->places()->attach($excursion->place_id);
          dump('excursion', $excursion->id, 'place', $excursion->place_id);
        }
      }
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
