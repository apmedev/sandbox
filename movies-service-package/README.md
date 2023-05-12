
# Movies Service Package

The Movies Service Package is a Laravel package that provides a convenient way to fetch popular movies using the OMDB API. It allows you to retrieve movie details such as title, genre, year, director, poster, and IMDB rating.

## Installation

You can install the package via Composer by running the following command:

```shell
composer require apmedev/movies-service
```

## Configuration

1. Publish the configuration file by running the following command:

```shell
php artisan vendor:publish --provider="YourVendorName\MoviesService\MoviesServiceProvider" --tag="config"
```

2. This command will publish the movies-service.php configuration file to your application's config directory.

3. In the config/movies-service.php file, enter your OMDB API key. This key is required to fetch movie data from the OMDB API.

4. Optionally, you can customize other configuration options such as the default year, number of returns, and genre.

## Usage

```code

use apmedev\MoviesService\MovieService;

// Instantiate the MovieService by passing the OMDB API key
$movieService = new MovieService('your-omdb-api-key');

// Fetch popular movies
$movies = $movieService->getPopularMovies();

// Output the movies
foreach ($movies as $movie) {
    echo $movie['title'] . ' (' . $movie['year'] . ')' . PHP_EOL;
    echo 'Genre: ' . $movie['genre'] . PHP_EOL;
    echo 'Director: ' . $movie['director'] . PHP_EOL;
    echo 'IMDB Rating: ' . $movie['imdbRating'] . PHP_EOL;
    echo 'Poster: ' . $movie['poster'] . PHP_EOL;
    echo '---' . PHP_EOL;
}

```

## License

This package is open-source software licensed under the MIT license.
