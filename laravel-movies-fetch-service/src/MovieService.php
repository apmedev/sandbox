<?php

namespace apmedev\MoviesService;
use Illuminate\Support\Facades\Http;

class MovieService
{
    protected $apiKey;
    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function getPopularMovies($year = null, $limit = 10, $withDetails = false, $genre = null)
    {
        $url = 'http://www.omdbapi.com/?apikey=' . $this->apiKey;

        if ($year !== null) {
            $url .= '&y=' . $year;
        }

        if ($genre !== null) {
            $url .= '&genre=' . $genre;
        }

        $response = Http::get($url);

        $movies = $response->json()['Search'];

        if ($withDetails) {
            $movies = $this->getMoviesWithDetails($movies);
        }

        return array_slice($movies, 0, $limit);
    }

    protected function getMoviesWithDetails($movies)
    {
        foreach ($movies as &$movie) {
            $detailsUrl = 'http://www.omdbapi.com/?apikey=' . $this->apiKey . '&i=' . $movie['imdbID'];
            $detailsResponse = Http::get($detailsUrl);
            $movie['details'] = $detailsResponse->json();
        }

        return $movies;
    }
}