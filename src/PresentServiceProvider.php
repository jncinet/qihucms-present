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
        $this->app->singleton(Present::class, function () {
            return new Present();
        });

        $this->app->alias(Present::class, 'qh-present');
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
