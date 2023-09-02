<?php

namespace App\Console\Commands;

use Goutte\Client;
use Illuminate\Console\Command;
use App\Models\Site;

class CrawlSites extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crawl:sites';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crawl assigned sites and update data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $sites = Site::all();

        foreach ($sites as $site) {
            $this->info('Crawling site: ' . $site->url);

            // Create Goutte client
            $client = new Client();
            $crawler = $client->request('GET', $site->url);

            // Extract data from the website
            $title = $crawler->filter('title')->text();
            $keywords = $crawler->filter('meta[name="keywords"]')->attr('content');

            // Update site data in the database
            $site->title = $title;
            $site->keywords = $keywords;
            $site->last_scraped = now();
            $site->save();

            $this->info('Crawling completed for site: ' . $site->url);
        }

        $this->info('All assigned sites crawled successfully!');
    }
}
