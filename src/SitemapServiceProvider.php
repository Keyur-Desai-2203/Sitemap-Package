<?php

namespace Keyur\Sitemap;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
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

        // if ($this->app->runningInConsole()) {
        //     $this->commands([
        //         GenerateSitemap::class,
        //     ]);
        // } else {
        //     Route::get('/sitemap', function () {
        //         Artisan::call('sitemap:generate');
        //         return response()->json(['message' => 'Sitemap generated successfully']);
        //     });
        // }
    }

    public function register()
    {

    }

}
