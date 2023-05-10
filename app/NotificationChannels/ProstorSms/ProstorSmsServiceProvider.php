<?php
/**
 * Created by PhpStorm.

 * Date: 12.12.2017
 * Time: 14:16
 */

namespace App\NotificationChannels\ProstorSms;


use Illuminate\Support\ServiceProvider;

class ProstorSmsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->app->when(ProstorSmsChannel::class)
            ->needs(ProstorSms::class)
            ->give(function () {
                return new ProstorSms(config('services.prostorsms'));
            });
    }
}