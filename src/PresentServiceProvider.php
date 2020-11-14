<?php

namespace Qihucms\Present;

use Illuminate\Support\ServiceProvider;

class PresentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('present', function () {
            return new Present();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes.php');
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'present');
        $this->loadMigrationsFrom(__DIR__.'/../migrations');
        $this->publishes([
            __DIR__ . '/../resources/lang' => resource_path('lang/vendor/present'),
        ]);
    }
}
