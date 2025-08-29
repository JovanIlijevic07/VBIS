<?php

namespace App\Controllers;

use App\Models\User;
use App\Core\Session;

class AuthController
{
    private $userModel;
    
    public function __construct()
    {
        $this->userModel = new User();
        Session::start();
    }

    public function showLogin()
    {
        include __DIR__ . '/../Views/auth/login.php';
    }
    
    public function processLogin()
{
    $usernameOrEmail = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $user = $this->userModel->login($usernameOrEmail, $password);

    if ($user) {
        Session::set('user_id', $user['id']);
        Session::set('username', $user['username']);
        Session::set('is_admin', $user['is_admin']);

        header('Location: ' . ($user['is_admin'] ? '/admin' : '/'));
        exit;
    } else {
        $error = 'Invalid username or password';
        include __DIR__ . '/../Views/auth/login.php';
    }
}
    
    public function showRegister()
    {
        include __DIR__ . '/../Views/auth/register.php';
    }

    // POST /register
    public function processRegister()
    {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        $email    = $_POST['email'] ?? '';

        if ($username && $password && $email) {
            $user = $this->userModel->register($username, $password, $email);

            Session::set('user_id', $user['id']);
            Session::set('username', $user['username']);
            Session::set('user_role', $user['role']);

            header('Location: /');
            exit;
        } else {
            $error = 'All fields are required';
            include __DIR__ . '/../Views/auth/register.php';
        }
    }
    public function logout()
    {
        Session::destroy();
        header('Location: /');
        exit;
    }
}