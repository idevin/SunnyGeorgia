<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::create('reviews', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('body');
            $table->integer('rating');
            $table->morphs('reviewable');
            $table->morphs('author');
            $table->timestamps();
        });
    }

    public function down()
    {
        \Schema::dropIfExists('reviews');
    }
}
