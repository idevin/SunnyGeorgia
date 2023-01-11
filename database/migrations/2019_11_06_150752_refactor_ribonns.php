<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RefactorRibonns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('ribands');

        Schema::table('ribbons', function (Blueprint $table) {
            $table->dropTimestamps();
        });
        Schema::table('ribbon_translations', function (Blueprint $table) {
            $table->dropTimestamps();
        });
        Schema::table('excursions', function (Blueprint $table) {
            $table->unsignedInteger('ribbon_id')->nullable();
            $table->foreign('ribbon_id')->references('id')->on('ribbons')->onDelete('set null');
        });
        Schema::table('tours', function (Blueprint $table) {
            $table->unsignedInteger('ribbon_id')->nullable();
            $table->foreign('ribbon_id')->references('id')->on('ribbons')->onDelete('set null');
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
