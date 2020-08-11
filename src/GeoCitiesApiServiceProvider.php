<?php


namespace fGalvao\GeoCitiesApi;

use fGalvao\BaseClientApi\HttpClient;
use fGalvao\GeoDB\GeoDB;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use Spekkionu\Assetcachebuster\HashReplacer\ConfigHashReplacer;
use Spekkionu\Assetcachebuster\Writer\ConfigWriter;

class GeoCitiesApiServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            realpath(__DIR__) . '/config/geo_cities_api.php' => config_path('geo_cities_api.php'),
        ], 'config');

    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            realpath(__DIR__) . '/config/geo_cities_api.php', 'geo_cities_api'
        );

        $this->app->singleton('geoCitiesApi', function ($app) {
            $settings = [
                'BASE_URL' => $app['config']['geo_cities_api']['BASE_URL'],
                'API_HOST' => $app['config']['geo_cities_api']['API_HOST'],
                'API_KEY'  => $app['config']['geo_cities_api']['API_KEY'],
                'DEV_MODE' => $app['config']['geo_cities_api']['DEV_MODE'],
            ];

            $clientSettings = GeoDB::buildClientSettings($settings);
            return new GeoDB(new HttpClient($clientSettings));
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['geoCitiesApi'];
    }
}