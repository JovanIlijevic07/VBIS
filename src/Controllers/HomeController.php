<?php

namespace App\Controllers;

use App\Models\Movie;
use App\Core\Session;

class HomeController
{
    private $movieModel;
    
    public function __construct()
    {
        $this->movieModel = new Movie();
        Session::start();
    }
    
    public function index()
    {
        $movies = $this->movieModel->getAllMovies();
        $isLoggedIn = Session::isLoggedIn();
        $username = Session::get('username');
        
        include __DIR__ . '/../Views/home/index.php';
    }
    
    public function search()
    {
        $query = $_GET['q'] ?? '';
        $movies = $query ? $this->movieModel->searchMovies($query) : $this->movieModel->getAllMovies();
        $isLoggedIn = Session::isLoggedIn();
        $username = Session::get('username');
        
        include __DIR__ . '/../Views/home/search.php';
    }
}