<?php
namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class MovieFetchService
{
    protected $httpClient;

    public function __construct(Client $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function fetch()
    {
        $url = 'http://www.omdbapi.com/?apikey=49733682&y=2020&type=movie&s=popular';
        try {
            $response = $this->httpClient->get($url);

            if ($response->getStatusCode() === 200) {
                $data = json_decode($response->getBody(), true);
                return $data['Search'];
            }
        } catch (GuzzleException $e) {
            // Handle exception
        }

        return null;
    }

    public function fetchMovieDetails($imdbId)
{
    $url = 'http://www.omdbapi.com/?apikey=49733682&i=' . $imdbId;

    try {
        $response = $this->httpClient->get($url);

        if ($response->getStatusCode() === 200) {
            $data = json_decode($response->getBody(), true);
            return $data;
        }
    } catch (\Exception $e) {
        // Handle exception
    }

    return [];
}
}
