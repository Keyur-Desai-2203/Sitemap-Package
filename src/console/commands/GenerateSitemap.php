<?php

namespace Keyur\Sitemap\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Generate a sitemap for the application';

    public function handle()
    {
        $routes = $this->getRoutes();
        $urls = $this->prepareUrls($routes);

        $xml = $this->generateXML($urls);

        $filePath = public_path('sitemap.xml');
        file_put_contents($filePath, $xml);

        $this->info('Sitemap generated successfully at ' . $filePath);
    }

    private function getRoutes()
    {
        $routes = Route::getRoutes();

        return collect($routes)->map(function ($route) {
            return $route->uri();
        })->toArray();
    }

    private function prepareUrls($routes)
    {
        $urls = [];
        foreach ($routes as $route) {
            $url = url($route);
            $urls[] = $url;
        }
        return $urls;
    }

    private function generateXML($urls)
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        foreach ($urls as $url) {
            $xml .= '<url>';
            $xml .= '<loc>' . htmlspecialchars($url) . '</loc>';
            $xml .= '</url>';
        }

        $xml .= '</urlset>';

        return $xml;
    }
}
