<?php


namespace fGalvao\GeoDbApi;

use fGalvao\BaseClientApi\HttpClient;
use fGalvao\GeoDB\GeoDB;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use Spekkionu\Assetcachebuster\HashReplacer\ConfigHashReplacer;
use Spekkionu\Assetcachebuster\Writer\ConfigWriter;

class GeoDbServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            realpath(__DIR__) . '/config/geodb.php' => config_path('geodb.php'),
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
            realpath(__DIR__) . '/config/geodb.php', 'geodb'
        );

        $this->app->singleton('geodb', function ($app) {
            $settings = [
                'BASE_URL' => $app['config']['geodb']['BASE_URL'],
                'API_HOST' => $app['config']['geodb']['API_HOST'],
                'API_KEY'  => $app['config']['geodb']['API_KEY'],
                'DEV_MODE' => $app['config']['geodb']['DEV_MODE'],
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
        return ['geodb'];
    }
}