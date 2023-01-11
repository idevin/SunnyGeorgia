<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGeneratedReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('generated_reviews', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->default('')->nullable();
            $table->text('body');
            $table->integer('rating');
            $table->morphs('reviewable');
            $table->string('avatar_name')->nullable();
            $table->string('avatar_url')->nullable();
            $table->string('author_name');
            $table->string('author_country')->nullable();
            $table->date('date');
            $table->boolean('published')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('generated_reviews');
    }
}
