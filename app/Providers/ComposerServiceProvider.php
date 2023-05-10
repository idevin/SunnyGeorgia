<?php
/**
 * Created by PhpStorm.

 * Date: 04.12.2017
 * Time: 14:20
 */

namespace App\Providers;


use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(
            [
                'site.includes.nav',
                'cabinet.profile',
                'cabinet.partner.tours.create',
                'cabinet.partner.tours.edit',
                'cabinet.partner.tours.accommodation',
                'cabinet.partner.hotels.create',
                'cabinet.partner.excursions.create',
                'cabinet.partner.excursions.edit',
                'control.tours.edit',
                'control.excursions.edit',
            ],
            \App\Http\ViewComposers\CurrencyComposer::class
        );
        View::composer(
            [
                'cabinet.partner.tours.create',
                'cabinet.partner.tours.create.step2',
                'cabinet.partner.tours.edit',
                'cabinet.partner.hotels.create',
                'cabinet.partner.excursions.create',
                'cabinet.partner.excursions.edit',
                'control.places.view',
                'control.tours.edit',
                'control.excursions.edit',
            ],
            \App\Http\ViewComposers\PlacesComposer::class
        );

        View::composer(
            [
                'site.includes.nav',
            ],
            \App\Http\ViewComposers\PlacesGroupsComposer::class
        );

        View::composer(
            [
                'cabinet.partner.tours.create',
                'cabinet.partner.tours.edit',
                'cabinet.partner.excursions.create',
                'cabinet.partner.excursions.edit',
                'control.options.edit',
                'control.options.create',
                'control.places.view',
                'control.tours.edit',
                'control.excursions.edit',
                'cabinet.profile',
                'site.includes.nav',
                'site.includes.alternates'
            ],
            \App\Http\ViewComposers\LanguagesComposer::class
        );

        View::composer(
            [
                'site.includes.nav',
                'site.includes.alternates'
            ],
            \App\Http\ViewComposers\AlternatesComposer::class
        );

        View::composer(
            [
                'cabinet.profile',
            ],
            \App\Http\ViewComposers\CountriesComposer::class
        );
        View::composer(
            [
                'site.layouts.auth_modals',
                'auth.register',
            ],
            \App\Http\ViewComposers\CountriesCodesComposer::class
        );
        View::composer(
            [
                'cabinet.layouts.header',
                'site.includes.nav',
            ],
            'App\Http\ViewComposers\UserComposer'
        );
        View::composer(
            [
                'control.excursions.edit',
                'control.tours.edit',
            ],
            'App\Http\ViewComposers\RibbonComposer'
        );

    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
