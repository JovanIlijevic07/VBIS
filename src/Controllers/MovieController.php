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
    $ordersRaw = $this->orderModel->getUserOrders($userId);

    $orders = [];
    foreach ($ordersRaw as $row) {
        $movie = $this->movieModel->getMovieById($row['movie_id']);
        if ($movie) {
            $orders[] = [
                'order_id'   => $row['order_id'],
                'created_at' => $row['order_date'],  // ovde je ključ iz baze
                'price'      => $row['price'],
                'movie_id'   => $row['movie_id'],
                'movie'      => [
                    'title' => $movie['title'],
                    'image' => $movie['image_url'] ?? '/images/placeholder.jpg'
                ]
            ];
        }
    }

    $username = Session::get('username');
    include __DIR__ . '/../Views/movies/orders.php';
}

    public function genreSalesStats()
{
    $orders = $this->orderModel->getAllOrders();
    $movies = $this->movieModel->getAllMovies();

    // Napravi mapu film_id => film
    $moviesById = [];
    foreach ($movies as $movie) {
        $moviesById[$movie['id']] = $movie;
    }

    $genreSales = [];

    foreach ($orders as $order) {
        $movieId = $order['movie_id'];
        $quantity = $order['quantity'] ?? 1;  // uzmi količinu iz order_items

        if (isset($moviesById[$movieId])) {
            $genre = $moviesById[$movieId]['genre'];

            if (!isset($genreSales[$genre])) {
                $genreSales[$genre] = 0;
            }

            // Dodaj stvarnu količinu prodatih primeraka
            $genreSales[$genre] += $quantity;
        }
    }

    header('Content-Type: application/json');
    echo json_encode($genreSales);
}

public function getGenreSalesForDashboard()
{
    $orders = $this->orderModel->getAllOrders();
    $movies = $this->movieModel->getAllMovies();

    // map film_id => film
    $moviesById = [];
    foreach ($movies as $movie) {
        $moviesById[$movie['id']] = $movie;
    }

    $genreSales = [];

    foreach ($orders as $order) {
        $movieId = $order['movie_id'];
        $quantity = $order['quantity'] ?? 1;

        if (isset($moviesById[$movieId])) {
            $genre = $moviesById[$movieId]['genre'];
            if (!isset($genreSales[$genre])) {
                $genreSales[$genre] = 0;
            }
            $genreSales[$genre] += $quantity;
        }
    }

    return $genreSales;
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