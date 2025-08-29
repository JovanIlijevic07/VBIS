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

        // Provera da li je korisnik ulogovan
        if (!Session::isLoggedIn()) {
            header('Location: /login');
            exit;
        }

        $this->userModel  = new User();
        $this->orderModel = new Order();
        $this->movieModel = new Movie();
    }

    // 1️⃣ Prikaz profila trenutnog korisnika
    public function profile()
    {
        $userId = Session::get('user_id');
        $user = $this->userModel->findById($userId);
        include __DIR__ . '/../Views/users/profile.php';
    }

    // 2️⃣ Izmena podataka profila
    public function editProfile()
    {
        $userId = Session::get('user_id');
        $user = $this->userModel->findById($userId);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $email    = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $updateData = [];
            if ($username) $updateData['username'] = $username;
            if ($email)    $updateData['email'] = $email;
            if ($password) $updateData['password'] = $password;

            if (!empty($updateData)) {
                $this->userModel->updateUser($userId, $updateData);
                Session::set('success_message', 'Profile updated successfully!');
            }

            // Refresh korisničkih podataka
            $user = $this->userModel->findById($userId);
        }

        include __DIR__ . '/../Views/users/edit_profile.php';
    }

    // 3️⃣ Pregled porudžbina trenutnog korisnika
   public function orders()
{
    $userId = Session::get('user_id');
    $orders = $this->orderModel->getUserOrders($userId);

    // Dodavanje informacija o filmovima u porudžbinu
    foreach ($orders as &$order) {
        $movie = $this->movieModel->getMovieById($order['movie_id']);
        $order['movie'] = [
            'title'       => $movie['title'],
            'image'       => $movie['image_url'], // ovde se uzima putanja iz baze
            'genre'       => $movie['genre'],
            'year'        => $movie['year'],
            'description' => $movie['description'],
            'price'       => $movie['price']
        ];
    }

    include __DIR__ . '/../Views/users/orders.php';
}

}
