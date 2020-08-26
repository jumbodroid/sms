<?php

namespace Jumbodroid\Sms\ServiceProviders;

use Illuminate\Support\ServiceProvider;

/**
 * Class SmsServiceProvider
 *
 * @author  Alois Odhiambo  <rayalois22@gmail.com>
 */
class SmsServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Boot the package.
     */
    public function boot()
    {
        /*
        |--------------------------------------------------------------------------
        | Publish the Config file from the Package to the App directory
        |--------------------------------------------------------------------------
        */
        $this->configPublisher();

        /*
        |
        |--------------------------------------------------------------------------
        | Publish the MIgration file from the Package to the App directory
        |--------------------------------------------------------------------------
        */
        $this->migrationPublisher();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        /*
        |--------------------------------------------------------------------------
        | Implementation Bindings
        |--------------------------------------------------------------------------
        */
        $this->implementationBindings();

        /*
        |--------------------------------------------------------------------------
        | Facade Bindings
        |--------------------------------------------------------------------------
        */
        $this->facadeBindings();

        /*
        |--------------------------------------------------------------------------
        | Registering Service Providers
        |--------------------------------------------------------------------------
        */
        $this->serviceProviders();
    }

    /**
     * Implementation Bindings
     */
    private function implementationBindings()
    {
        // $this->app->singleton(RbacInterface::class, Rbac::class);
    }

    /**
     * Publish the Config file from the Package to the App directory
     */
    private function configPublisher()
    {
        // When users execute Laravel's vendor:publish command, the config file will be copied to the specified location
        $this->publishes([
            dirname(__DIR__) . '/Config/sms.php' => config_path('sms.php'),
        ]);
    }

    /**
     * Publish the Migration file from the Package to the App directory
     */
    private function migrationPublisher()
    {
        // When users execute Laravel's vendor:publish command, the migration file will be copied to the specified location
        $this->publishes([
            dirname(__DIR__) . '/Migrations/2020_08_18_133916_create_sms_tables.php' => database_path('migrations/2020_08_18_133916_create_sms_tables.php'),
        ]);
    }

    /**
     * Facades Binding
     */
    private function facadeBindings()
    {
        // none
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    /**
     * Registering Other Custom Service Providers (if you have)
     */
    private function serviceProviders()
    {
        // $this->app->register('...\...\...');
    }

}
