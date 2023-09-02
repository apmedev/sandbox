<?php

namespace YourVendorName\MoviesService\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;

class MoviesServiceApiKeyCommand extends Command
{
    protected $signature = 'movies-service:api-key';

    protected $description = 'Set the API key for the Movies Service package';

    public function handle()
    {
        $apiKey = $this->ask('Enter your Movies Service API key:');

        $this->updateConfigFile($apiKey);

        $this->info('API key set successfully!');
    }

    protected function updateConfigFile($apiKey)
    {
        $configFile = base_path('vendor/apmedev/movies-service/config/movies-service.php');

        if (File::exists($configFile)) {
            $configContents = File::get($configFile);
            $updatedConfigContents = str_replace(
                "'api_key' => env('MOVIES_SERVICE_API_KEY')",
                "'api_key' => '{$apiKey}'",
                $configContents
            );
            File::put($configFile, $updatedConfigContents);
        }
    }
}