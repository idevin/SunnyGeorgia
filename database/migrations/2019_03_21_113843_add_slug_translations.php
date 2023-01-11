<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSlugTranslations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::table('excursion_translations', function (Blueprint $table) {
            $table->string('slug')->unique()->nullable();
        });
        \Schema::table('tour_translations', function (Blueprint $table) {
            $table->string('slug')->unique()->nullable();
        });
        \Schema::table('place_translations', function (Blueprint $table) {
            $table->string('slug')->unique()->nullable();
        });
        \Schema::table('page_translations', function (Blueprint $table) {
            $table->string('slug')->unique()->nullable();
        });

        $tables = [
            ['places', 'place_translations', 'place_id'],
            ['excursions','excursion_translations', 'excursion_id'],
            ['pages','page_translations', 'page_id'],
            ['tours','tour_translations', 'tour_id'],
        ];

        foreach ($tables as $table) {
            $rows = \Illuminate\Support\Facades\DB::table($table[0])->get();
            foreach ($rows as $row) {
                if($row->slug) {
                    \Illuminate\Support\Facades\DB::table($table[1])
                        ->where($table[2], $row->id)
                        ->where('locale', 'ru')
                        ->update(['slug' => $row->slug]);
                }
            }
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
