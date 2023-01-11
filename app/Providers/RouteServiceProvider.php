<?php

namespace App\Providers;

use App\Models\Excursions\Excursion;
use App\Models\Tours\Tour;
use App\Place;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Traits\LoadsTranslatedCachedRoutes;

class RouteServiceProvider extends ServiceProvider
{
    use LoadsTranslatedCachedRoutes;
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Route::bind('excursion', function ($value) {
            return Excursion::whereTranslation('slug', $value)->firstOrFail();
        });
        Route::bind('tour', function ($value) {
            return Tour::whereTranslation('slug', $value)->firstOrFail();
        });
//        Route::bind('place', function ($value) {
//            return Place::whereTranslation('slug', $value)->firstOrFail();
//        });
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware(['cabinet_web'])
            ->namespace($this->namespace)
            ->group(base_path('routes/control.php'));
        Route::middleware(['cabinet_web'])
            ->namespace($this->namespace)
            ->group(base_path('routes/cabinet.php'));
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/site.php'));
    }
}
