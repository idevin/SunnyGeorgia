<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMetaFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tour_translations', function (Blueprint $table) {
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
        });
        Schema::table('excursion_translations', function (Blueprint $table) {
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
        });
        Schema::table('place_translations', function (Blueprint $table) {
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
        });

        DB::statement('ALTER TABLE public.place_translations RENAME COLUMN keywords TO meta_keywords;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tour_translations', function (Blueprint $table) {
            $table->dropColumn('meta_title', 'meta_description', 'meta_keywords');
        });
        Schema::table('excursion_translations', function (Blueprint $table) {
            $table->dropColumn('meta_title', 'meta_description', 'meta_keywords');
        });
        Schema::table('place_translations', function (Blueprint $table) {
            $table->dropColumn('meta_title', 'meta_description');
        });
        DB::statement('ALTER TABLE public.place_translations RENAME COLUMN meta_keywords TO keywords;');

    }
}
