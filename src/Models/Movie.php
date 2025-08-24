<?php

namespace App\Models;

use App\Core\Database;

class Movie
{
    private $db;
    private static $movies = [
        1 => ['id' => 1, 'title' => 'The Matrix', 'description' => 'A computer programmer discovers reality is a simulation.', 'price' => 9.99, 'genre' => 'Sci-Fi', 'year' => 1999, 'image' => 'matrix.jpg'],
        2 => ['id' => 2, 'title' => 'Inception', 'description' => 'A thief enters peoples dreams to steal secrets.', 'price' => 12.99, 'genre' => 'Thriller', 'year' => 2010, 'image' => 'inception.jpg'],
        3 => ['id' => 3, 'title' => 'Interstellar', 'description' => 'Astronauts travel through a wormhole to save humanity.', 'price' => 11.99, 'genre' => 'Sci-Fi', 'year' => 2014, 'image' => 'interstellar.jpg'],
        4 => ['id' => 4, 'title' => 'The Dark Knight', 'description' => 'Batman faces the Joker in Gotham City.', 'price' => 10.99, 'genre' => 'Action', 'year' => 2008, 'image' => '/images/Batman.jpg'],
        5 => ['id' => 5, 'title' => 'Pulp Fiction', 'description' => 'Interconnected stories of crime in Los Angeles.', 'price' => 8.99, 'genre' => 'Crime', 'year' => 1994, 'image' => 'pulp_fiction.jpg'],
        6 => ['id' => 6, 'title' => 'Forrest Gump', 'description' => 'The extraordinary life of a simple man.', 'price' => 9.99, 'genre' => 'Drama', 'year' => 1994, 'image' => 'forrest_gump.jpg']
    ];
    
    public function __construct()
    {
        $this->db = new Database();
    }
    
    public function getAllMovies()
    {
        return self::$movies;
    }
    
    public function getMovieById($id)
    {
        return self::$movies[$id] ?? false;
    }
    
    public function getMoviesByGenre($genre)
    {
        return array_filter(self::$movies, function($movie) use ($genre) {
            return strcasecmp($movie['genre'], $genre) === 0;
        });
    }
    
    public function searchMovies($query)
    {
        return array_filter(self::$movies, function($movie) use ($query) {
            return stripos($movie['title'], $query) !== false || 
                   stripos($movie['description'], $query) !== false;
        });
    }
    
    public function getMovieStats()
    {
        $genres = array_count_values(array_column(self::$movies, 'genre'));
        $avgPrice = array_sum(array_column(self::$movies, 'price')) / count(self::$movies);
        
        return [
            'total_movies' => count(self::$movies),
            'genres' => $genres,
            'average_price' => round($avgPrice, 2),
            'latest_movie' => end(self::$movies)
        ];
    }
}