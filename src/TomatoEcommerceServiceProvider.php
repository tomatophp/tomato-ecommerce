<?php

namespace TomatoPHP\TomatoEcommerce;

use Illuminate\Support\ServiceProvider;
use TomatoPHP\TomatoAdmin\Facade\TomatoSlot;

include  __DIR__ . '/helpers.php';

class TomatoEcommerceServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //Register generate command
        $this->commands([
           \TomatoPHP\TomatoEcommerce\Console\TomatoEcommerceInstall::class,
        ]);

        //Register Config file
        $this->mergeConfigFrom(__DIR__.'/../config/tomato-ecommerce.php', 'tomato-ecommerce');

        //Publish Config
        $this->publishes([
           __DIR__.'/../config/tomato-ecommerce.php' => config_path('tomato-ecommerce.php'),
        ], 'tomato-ecommerce-config');

        //Register Migrations
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        //Publish Migrations
        $this->publishes([
           __DIR__.'/../database/migrations' => database_path('migrations'),
        ], 'tomato-ecommerce-migrations');
        //Register views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'tomato-ecommerce');

        //Publish Views
        $this->publishes([
           __DIR__.'/../resources/views' => resource_path('views/vendor/tomato-ecommerce'),
        ], 'tomato-ecommerce-views');

        //Register Langs
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'tomato-ecommerce');

        //Publish Lang
        $this->publishes([
           __DIR__.'/../resources/lang' => app_path('lang/vendor/tomato-ecommerce'),
        ], 'tomato-ecommerce-lang');

        //Register Routes
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

    }

    public function boot(): void
    {
        app()->bind('tomato-ecommerce', function () {
            return new \TomatoPHP\TomatoEcommerce\Services\Ecommerce;
        });

        TomatoSlot::navBeforeUserDropdown('tomato-ecommerce::ecommerce.icon');

    }
}
