<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\PlaceTranslation;

class ChangeMetaToPlaceTranslations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();
        Schema::table('place_translations', function (Blueprint $table) {
            $table->json('meta_title')->default(json_encode(["main"=>"", "excursion"=>"", "tour"=>""]));
            $table->json('meta_description')->default(json_encode(["main"=>"", "excursion"=>"", "tour"=>""]));
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('place_translations', function (Blueprint $table) {
            $table->dropColumn('meta_title');
            $table->dropColumn('meta_description');
        });
    }
}
