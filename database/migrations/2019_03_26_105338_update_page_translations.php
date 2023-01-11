<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePageTranslations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \App\Models\Pages\PageTranslation::query()->whereLocale('ge')->update([
            'locale' => 'ka'
        ]);
        \App\PlaceTranslation::query()->whereLocale('ge')->update([
            'locale' => 'ka'
        ]);
        \App\PlacesGroupTranslation::query()->whereLocale('ge')->update([
            'locale' => 'ka'
        ]);
        \App\OptionTranslation::query()->whereLocale('ge')->update([
            'locale' => 'ka'
        ]);
        \App\OptionsGroupTranslation::query()->whereLocale('ge')->update([
            'locale' => 'ka'
        ]);
        \App\Models\Tours\AccommodationTranslation::query()->whereLocale('ge')->update([
            'locale' => 'ka'
        ]);
        \App\Models\Excursions\ExcursionTranslation::query()->whereLocale('ge')->update([
            'locale' => 'ka'
        ]);
        \App\Models\Hotels\HotelTranslation::query()->whereLocale('ge')->update([
            'locale' => 'ka'
        ]);
        \App\RibbonTranslation::query()->whereLocale('ge')->update([
            'locale' => 'ka'
        ]);
        \App\Models\Tours\TourTranslation::query()->whereLocale('ge')->update([
            'locale' => 'ka'
        ]);
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
