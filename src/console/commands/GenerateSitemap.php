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

            $lastModified = $this->generateLastModified(); // Replace this with your logic to generate last modified date
        $changeFrequency = $this->generateChangeFrequency(); // Replace this with your logic to generate change frequency
        $priority = $this->generatePriority(); // Replace this with your logic to generate priority


            $xml .= '<url>';
            $xml .= '<loc>' . htmlspecialchars($url) . '</loc>';
            $xml .= '<lastmod>' . $lastModified . '</lastmod>';
            $xml .= '<changefreq>' . $changeFrequency . '</changefreq>';
            $xml .= '<priority>' . $priority . '</priority>';
            $xml .= '</url>';
        }

        $xml .= '</urlset>';

        return $xml;
    }
    private function generateLastModified()
{
    // Replace this with your logic to generate last modified date dynamically
    // For example, retrieving the last modified date from your database for each URL
    // This is a placeholder; replace it with your actual logic
    // return YourModel::where('url', $url)->latest('updated_at')->value('updated_at');
    return date('Y-m-d');
}

private function generateChangeFrequency()
{
    // Replace this with your logic to generate change frequency dynamically
    // This is a placeholder; you might determine change frequency based on the URL type or other factors
    // Example logic:
    $changeFrequencies = ['always', 'hourly', 'daily', 'weekly', 'monthly', 'yearly', 'never'];
    return $changeFrequencies[rand(0, count($changeFrequencies) - 1)]; // Randomly select a change frequency
}

private function generatePriority()
{
    // Replace this with your logic to generate priority dynamically
    // This is a placeholder; you might determine priority based on the importance of the URL
    // Example logic:
    $priorityValues = ['0.1', '0.2', '0.3', '0.4', '0.5', '0.6', '0.7', '0.8', '0.9', '1.0'];
    return $priorityValues[rand(0, count($priorityValues) - 1)]; // Randomly select a priority value
}

}
