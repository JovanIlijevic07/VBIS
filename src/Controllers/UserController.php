<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Movie;
use App\Core\Session;

class UserController
{
    private $userModel;
    private $orderModel;
    private $movieModel;

    public function __construct()
    {
        Session::start();

       
        if (!Session::isLoggedIn()) {
            header('Location: /login');
            exit;
        }

        $this->userModel = new User();
        $this->orderModel = new Order();
        $this->movieModel = new Movie();
    }

    
    public function profile()
    {
        $userId = Session::get('user_id');
        $user = $this->userModel->findById($userId);
        include __DIR__ . '/../Views/users/profile.php';
    }

    
    public function editProfile()
    {
        $userId = Session::get('user_id');
        $user = $this->userModel->findById($userId);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $updateData = [];
            if ($username)
                $updateData['username'] = $username;
            if ($email)
                $updateData['email'] = $email;
            if ($password)
                $updateData['password'] = $password;

            if (!empty($updateData)) {
                $this->userModel->updateUser($userId, $updateData);
                Session::set('success_message', 'Profile updated successfully!');
            }

            
            $user = $this->userModel->findById($userId);
        }

        include __DIR__ . '/../Views/users/edit_profile.php';
    }

    
    public function orders()
    {
        $userId = Session::get('user_id');
        $orders = $this->orderModel->getUserOrders($userId);

        
        foreach ($orders as &$order) {
            $movie = $this->movieModel->getMovieById($order['movie_id']);
            $order['movie'] = [
                'title' => $movie['title'],
                'image' => $movie['image_url'], 
                'genre' => $movie['genre'],
                'year' => $movie['year'],
                'description' => $movie['description'],
                'price' => $movie['price']
            ];
        }

        include __DIR__ . '/../Views/users/orders.php';
    }

}
