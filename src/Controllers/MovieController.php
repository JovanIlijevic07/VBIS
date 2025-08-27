<?php

namespace App\Controllers;

use App\Models\Movie;
use App\Models\Order;
use App\Core\Session;

class MovieController
{
    private $movieModel;
    private $orderModel;
    
    public function __construct()
    {
        $this->movieModel = new Movie();
        $this->orderModel = new Order();
        Session::start();
    }
    
    public function show()
    {
        $id = $_GET['id'] ?? 0;
        $movie = $this->movieModel->getMovieById($id);
        
        if (!$movie) {
            header('Location: /');
            exit;
        }
        
        $isLoggedIn = Session::isLoggedIn();
        $username = Session::get('username');
        
        include __DIR__ . '/../Views/movies/show.php';
    }
    
    public function buy()
    {
        if (!Session::isLoggedIn()) {
            header('Location: /login');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $movieId = $_POST['movie_id'] ?? 0;
            $movie = $this->movieModel->getMovieById($movieId);
            
            if ($movie) {
                $userId = Session::get('user_id');
                $order = $this->orderModel->createOrder($userId, $movieId, $movie['price']);
                
                Session::set('success_message', 'Movie purchased successfully!');
                header('Location: /orders');
                exit;
            }
        }
        
        header('Location: /');
        exit;
    }
    
    public function orders()
    {
        if (!Session::isLoggedIn()) {
            header('Location: /login');
            exit;
        }
        
        $userId = Session::get('user_id');
        $orders = $this->orderModel->getUserOrders($userId);
        $username = Session::get('username');
        
        // Get movie details for each order
        foreach ($orders as &$order) {
            $order['movie'] = $this->movieModel->getMovieById($order['movie_id']);
        }
        
        include __DIR__ . '/../Views/movies/orders.php';
    }

    public function genreSalesStats()
{
    $orders = $this->orderModel->getAllOrders();
    $movies = $this->movieModel->getAllMovies();

    $genreSales = [];

    foreach ($orders as $order) {
        $movieId = $order['movie_id'];
        if (isset($movies[$movieId])) {
            $genre = $movies[$movieId]['genre'];
            if (!isset($genreSales[$genre])) {
                $genreSales[$genre] = 0;
            }
            $genreSales[$genre]++;
        }
    }

    header('Content-Type: application/json');
    echo json_encode($genreSales);
}

public function revenueOverTime()
{
    $orders = $this->orderModel->getAllOrders();
    $revenueByDate = [];

    foreach ($orders as $order) {
        $date = date('Y-m-d', strtotime($order['created_at']));
        if (!isset($revenueByDate[$date])) {
            $revenueByDate[$date] = 0;
        }
        $revenueByDate[$date] += $order['price'];
    }

    ksort($revenueByDate);

    header('Content-Type: application/json');
    echo json_encode($revenueByDate);
}
}