<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExcursionTypeTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('excursion_type_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('excursion_type_id');
            $table->string('name');
            $table->string('locale')->index();

            $table->unique(['excursion_type_id','locale']);
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
        Schema::dropIfExists('excursion_type_translations');
    }
}
