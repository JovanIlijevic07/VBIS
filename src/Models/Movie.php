<?php

namespace App\Models;

use App\Core\Database;

class Movie
{
    
    public function __construct()
    {
        $this->db = new Database();
    }
    
    public function getAllMovies()
    {
        $stmt = $this->db->query("SELECT * FROM movies");
        return $stmt->fetchAll();
    }
    
     public function getMovieById($id)
    {
        $stmt = $this->db->query("SELECT * FROM movies WHERE id = ?", [$id]);
        return $stmt->fetch();
    }
    
    public function getMoviesByGenre($genre)
    {
        $stmt = $this->db->query("SELECT * FROM movies WHERE genre = ?", [$genre]);
        return $stmt->fetchAll();
    }
    public function searchMovies($query)
{
    $stmt = $this->db->query(
        "SELECT * FROM movies 
         WHERE title LIKE ? 
            OR genre LIKE ? 
            OR year LIKE ?",
        ["%$query%", "%$query%", "%$query%"]
    );
    return $stmt->fetchAll();
}
    public function getMovieStats()
{
    $stats = [];

    // Ukupan broj filmova
    $stmt = $this->db->query("SELECT COUNT(*) as total FROM movies");
    $stats['total_movies'] = $stmt->fetch()['total'];

    // Prosečna cena
    $stmt = $this->db->query("SELECT AVG(price) as avg_price FROM movies");
    $stats['average_price'] = round($stmt->fetch()['avg_price'], 2);

    // Najnoviji film
    $stmt = $this->db->query("SELECT * FROM movies ORDER BY id DESC LIMIT 1");
    $stats['latest_movie'] = $stmt->fetch();

    // 📊 Broj filmova po žanru
    $stmt = $this->db->query("SELECT genre, COUNT(*) as count FROM movies GROUP BY genre");
    $genres = $stmt->fetchAll();

    $genreData = [];
    foreach ($genres as $row) {
        $genreData[$row['genre']] = (int)$row['count'];
    }
    $stats['genres'] = $genreData;

    return $stats;
}

}