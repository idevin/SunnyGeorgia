<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('options_groups', function (Blueprint $table) {
            $table->increments('id');

            $table->boolean('main_list')->default(false);

            $table->boolean('tours')->default(false);
            $table->boolean('excursions')->default(false);
            $table->boolean('hotels')->default(false);
            $table->boolean('rooms')->default(false);
            $table->boolean('options')->default(false);
            $table->boolean('price')->default(false);
            $table->timestamps();
        });
        Schema::create('options_group_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('options_group_id')->unsigned();
            $table->string('locale', 10)->index();
            $table->string('title', 255)->nullable();

            $table->unique(['options_group_id', 'locale']);
            $table->foreign('options_group_id')->references('id')->on('options_groups')->onDelete('cascade');
        });

        Schema::create('options', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('group_id');

            $table->foreign('group_id')->references('id')->on('options_groups')->onDelete('cascade');
            $table->timestamps();
        });
        Schema::create('option_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('option_id')->unsigned();
            $table->string('locale', 10)->index();
            $table->string('title', 255)->nullable();
            $table->string('description', 255)->nullable();

            $table->unique(['option_id', 'locale']);
            $table->foreign('option_id')->references('id')->on('options')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('option_translations');
        Schema::dropIfExists('options');
        Schema::dropIfExists('options_group_translations');
        Schema::dropIfExists('options_groups');
    }
}
