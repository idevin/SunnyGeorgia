<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateToursWithNoindexColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tours', function (Blueprint $table) {
            $table->boolean('noindex_ru')->default(false);
            $table->boolean('noindex_ge')->default(true);
            $table->boolean('noindex_en')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tours', function (Blueprint $table) {
            $table->dropColumn('noindex_ru');
            $table->dropColumn('noindex_ge');
            $table->dropColumn('noindex_en');
        });
    }
}
