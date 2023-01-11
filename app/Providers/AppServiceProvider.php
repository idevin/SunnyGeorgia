<?php

namespace App\Providers;

use App\BankPayment;
use App\Models\Excursions\Excursion;
use App\Models\Excursions\ExcursionBooking;
use App\Models\Excursions\Observers\ExcursionBookingObserver;
use App\Models\Excursions\Observers\ExcursionObserver;
use App\Models\Tours\Observers\TourBookingObserver;
use App\Models\Tours\Observers\TourObserver;
use App\Models\Tours\Tour;
use App\Models\Tours\TourBooking;
use App\Observers\BankPaymentObserver;
use App\Observers\PartnerObserver;
use App\Observers\UserObserver;
use App\Partner;
use App\User;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Validator;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        TourBooking::observe(TourBookingObserver::class);
        Tour::observe(TourObserver::class);
        ExcursionBooking::observe(ExcursionBookingObserver::class);
        Excursion::observe(ExcursionObserver::class);
        BankPayment::observe(BankPaymentObserver::class);
        User::observe(UserObserver::class);
        Partner::observe(PartnerObserver::class);
        Validator::extend(
            'recaptcha',
            'App\Http\Validators\ReCaptcha@validate'
        );
        Blade::withoutComponentTags();
        Paginator::useBootstrap();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }
}
