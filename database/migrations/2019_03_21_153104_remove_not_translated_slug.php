<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveNotTranslatedSlug extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (\Schema::hasColumn('excursions', 'slug')) {
            \Schema::table('excursions', function (Blueprint $table) {
                $table->dropColumn('slug');
            });
        }
        if (\Schema::hasColumn('tours', 'slug')) {
            \Schema::table('tours', function (Blueprint $table) {
                $table->dropColumn('slug');
            });
        }
        if (\Schema::hasColumn('pages', 'slug')) {
            \Schema::table('pages', function (Blueprint $table) {
                $table->dropColumn('slug');
            });
        }
        if (\Schema::hasColumn('places', 'slug')) {
            \Schema::table('places', function (Blueprint $table) {
                $table->dropColumn('slug');
            });
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
