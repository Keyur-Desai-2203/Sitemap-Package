<?php

namespace Keyur\Sitemap;

use Illuminate\Support\ServiceProvider;
use Keyur\Sitemap\Console\Commands\GenerateSitemap;
class SitemapServiceProvider extends ServiceProvider
{

    public function boot()
    {
        // Publishes the configuration file if needed
        $this->publishes([
            __DIR__.'/config/sitemap.php' => config_path('sitemap.php'),
        ], 'config');

        if ($this->app->runningInConsole()) {
            $this->commands([
                GenerateSitemap::class,
            ]);
        }
    }

    public function register()
    {

    }

}
