<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameNoindexColunms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::table('excursions', function (Blueprint $table) {
            $table->renameColumn('noindex_ge', 'noindex_ka');
        });
        \Schema::table('tours', function (Blueprint $table) {
            $table->renameColumn('noindex_ge', 'noindex_ka');
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
