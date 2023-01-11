<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTourTypeTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tour_type_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('tour_type_id');
            $table->string('name');
            $table->string('locale')->index();

            $table->unique(['tour_type_id','locale']);
            $table->foreign('tour_type_id')->references('id')->on('tour_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tour_type_translations');
    }
}
