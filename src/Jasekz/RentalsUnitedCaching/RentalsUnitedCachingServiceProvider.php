<?php
namespace Jasekz\RentalsUnitedCaching;

use Illuminate\Support\ServiceProvider;
use Jasekz\RentalsUnitedCaching\RentalsUnitedCaching;
use Jasekz\RentalsUnitedCaching\Commands\CacheAllCommand;
use Jasekz\RentalsUnitedCaching\Commands\CacheDictionariesCommand;
use Jasekz\RentalsUnitedCaching\Commands\CachePropertiesCommand;
use Jasekz\RentalsUnitedCaching\Commands\UpdateChangeLogCommand;
use Jasekz\RentalsUnitedCaching\Commands\UpdatePropertiesCommand;
use Jasekz\RentalsUnitedCaching\Commands\CacheReservationsCommand;
use Jasekz\RentalsUnitedCaching\Commands\PutAvbUnitsCommand;

class RentalsUnitedCachingServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/config.php' => config_path('rentals_united_caching.php')
        ]);
        
        $this->publishes([
            __DIR__ . '/database/migrations/' => database_path('migrations')
        ], 'migrations');

        $this->commands('command.ru.cache_all');
        $this->commands('command.ru.cache_dictionaries');
        $this->commands('command.ru.cache_properties');
        $this->commands('command.ru.update_change_log');
        $this->commands('command.ru.update_properties');
        $this->commands('command.ru.cache_reservations');
        $this->commands('command.ru.put_avb_units');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('ru', function ($app) {
            return new RentalsUnitedCaching($app);
        });
        
        $this->app->singleton('command.ru.cache_all', function ($app) {
            return new CacheAllCommand();
        });

        $this->app->singleton('command.ru.cache_dictionaries', function ($app) {
            return new CacheDictionariesCommand();
        });
        
        $this->app->singleton('command.ru.cache_properties', function ($app) {
            return new CachePropertiesCommand();
        });
        
        $this->app->singleton('command.ru.update_change_log', function ($app) {
            return new UpdateChangeLogCommand();
        });
        
        $this->app->singleton('command.ru.update_properties', function ($app) {
            return new UpdatePropertiesCommand();
        });

        $this->app->singleton('command.ru.cache_reservations', function ($app) {
            return new CacheReservationsCommand();
        });

        $this->app->singleton('command.ru.put_avb_units', function ($app) {
            return new PutAvbUnitsCommand();
        });
    }
}
