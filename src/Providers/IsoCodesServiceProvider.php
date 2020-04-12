<?php

namespace Limanweb\IsoCodes\Providers;

use Illuminate\Support\ServiceProvider;

class IsoCodesServiceProvider extends ServiceProvider
{
    
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang/', 'iso_codes');

        $this->publishes([
            __DIR__.'/../resources/lang/' => resource_path('lang/vendor/iso_codes'),
            __DIR__.'/../config/iso_currency.php' => config_path('iso_currency.php'),
            // __DIR__.'/../config/iso_country.php' => config_path('iso_country.php'),
        ]);
        
    }
    
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}