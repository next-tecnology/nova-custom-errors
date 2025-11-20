<?php
namespace NextTecnology\NovaCustomErrors;

use Illuminate\Support\ServiceProvider;

class NovaCustomErrorsServiceProvider  extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'nova-custom-errors');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/nova-custom-errors'),
        ], 'nova-custom-errors-views');
    }

    public function register()
    {
        //
    }
}
