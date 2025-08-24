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
}