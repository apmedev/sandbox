<?php

namespace Database\Seeders;

use App\Services\MovieFetchService;
use Illuminate\Database\Seeder;
use App\Models\Movie;
class MovieSeeder extends Seeder
{
    protected $movieFetchService;

    public function __construct(MovieFetchService $movieFetchService)
    {
        $this->movieFetchService = $movieFetchService;
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $movies = $this->movieFetchService->fetch();

        if ($movies) {
            foreach ($movies as $movieData) {
                $movieDetails = $this->movieFetchService->fetchMovieDetails($movieData['imdbID']);

                $movie = new Movie();
                $movie->title = $movieData['Title'];
                $movie->released = $movieDetails['Released'];
                $movie->runtime = $movieDetails['Runtime'];
                $movie->genre = $movieDetails['Genre'];
                $movie->year = $movieDetails['Year'];
                $movie->director = $movieDetails['Director'];
                $movie->poster = $movieData['Poster'];
                $movie->imdbRating = $movieDetails['imdbRating'];
                $movie->save();
            }
        }

    }
}
