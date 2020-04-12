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

        $this->loadTranslationsFrom(__DIR__.'/../resources/lang/', 'limanweb/iso_codes');
        
        $this->publishes([
            // __DIR__.'/../resources/lang' => resource_path('lang/vendor/iso_codes'),
            __DIR__.'/../config' => config_path('vendor/iso_codes'),
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