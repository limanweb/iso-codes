<?php

namespace Limanweb\IsoCodes\Providers;

use Illuminate\Support\ServiceProvider;
use Limanweb\IsoCodes\Services\IsoCodesService;

class IsoCodesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang/', 'limanweb/iso_codes');

        $this->publishes([
            __DIR__.'/../config' => config_path('limanweb/iso_codes'),
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(IsoCodesService::class, function() {
            return new IsoCodesService;
        });
    }
}