<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPublishedAndTrustedFlags extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('trusted')->default(false);
        });
        Schema::table('tours', function (Blueprint $table) {
            $table->boolean('reviewed')->default(false);
        });
        Schema::table('excursions', function (Blueprint $table) {
            $table->boolean('reviewed')->default(false);
        });
        Schema::table('hotels', function (Blueprint $table) {
            $table->boolean('reviewed')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('trusted');
        });
        Schema::table('tours', function (Blueprint $table) {
            $table->dropColumn('reviewed');
        });
        Schema::table('excursions', function (Blueprint $table) {
            $table->dropColumn('reviewed');
        });
        Schema::table('hotels', function (Blueprint $table) {
            $table->dropColumn('reviewed');
        });
    }
}
