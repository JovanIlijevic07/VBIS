<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Movie;
use App\Models\Order;
use App\Core\Session;

class AdminController
{
    private $userModel;
    private $movieModel;
    private $orderModel;
    
    public function __construct()
    {
        Session::start();
        
        if (!Session::isAdmin()) {
            header('Location: /');
            exit;
        }
        
        $this->userModel = new User();
        $this->movieModel = new Movie();
        $this->orderModel = new Order();
    }
    
    public function dashboard()
{
    $userStats = $this->userModel->getUserStats();
    $movieStats = $this->movieModel->getMovieStats();
    $orderStats = $this->orderModel->getOrderStats();

    // Dodaj dnevnu zaradu
    $orderStats['daily_revenue'] = $this->orderModel->getDailyRevenueLast30Days();

    // Dodaj prodaju po žanrovima
    $soldByGenre = $this->orderModel->getSoldByGenre();

    $username = Session::get('username');
    
    include __DIR__ . '/../Views/admin/dashboard.php';
}

    
    public function users()
    {
        $users = $this->userModel->getAllUsers();
        $username = Session::get('username');
        
        include __DIR__ . '/../Views/admin/users.php';
    }
    
    public function deleteUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_POST['user_id'] ?? 0;
            
            if ($this->userModel->deleteUser($userId)) {
                Session::set('success_message', 'User deleted successfully');
            } else {
                Session::set('error_message', 'Failed to delete user');
            }
        }
        
        header('Location: /admin/users');
        exit;
    }
    
    public function editUser()
    {
        $userId = $_GET['id'] ?? 0;
        $user = $this->userModel->findById($userId);
        
        if (!$user || $user['role'] === 'admin') {
            header('Location: /admin/users');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            
            if ($username && $email) {
                $this->userModel->updateUser($userId, [
                    'username' => $username,
                    'email' => $email
                ]);
                
                Session::set('success_message', 'User updated successfully');
                header('Location: /admin/users');
                exit;
            } else {
                $error = 'All fields are required';
            }
        }
        
        $adminUsername = Session::get('username');
        
        include __DIR__ . '/../Views/admin/edit_user.php';
    }
}