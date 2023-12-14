<?php

namespace Keyur\Sitemap;

use Illuminate\Support\ServiceProvider;
class SitemapServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        
    }

    public function register()
    {

    }

}
