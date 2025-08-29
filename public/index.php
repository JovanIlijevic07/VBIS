<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Core\Router;
use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Controllers\MovieController;
use App\Controllers\AdminController;
use App\Controllers\UserController;
use App\Controllers\CartController;

$router = new Router();

// Public routes
$router->get('/', HomeController::class, 'index');
$router->get('search', HomeController::class, 'search');
$router->get('movie', MovieController::class, 'show');

// Authentication routes
$router->get('login', AuthController::class, 'showLogin');
$router->post('login', AuthController::class, 'processLogin');
$router->get('register', AuthController::class, 'showRegister');
$router->post('register', AuthController::class, 'processRegister');
$router->get('logout', AuthController::class, 'logout');

// User routes
$router->post('buy', MovieController::class, 'buy');
$router->get('orders', MovieController::class, 'orders');
$router->get('user/profile', UserController::class, 'profile');          // prikaz profila
$router->get('user/edit-profile', UserController::class, 'editProfile'); // GET prikaz forme
$router->post('user/edit-profile', UserController::class, 'editProfile'); // POST čuvanje izmena
$router->get('user/orders', UserController::class, 'orders');           // pregled porudžbina

$router->get('cart', CartController::class, 'index');
$router->post('cart/add', CartController::class, 'add');
$router->post('cart/buy', CartController::class, 'buy');
$router->post('cart/update', CartController::class, 'update');
$router->post('cart/remove', CartController::class, 'remove');
// Admin routes
$router->get('admin', AdminController::class, 'dashboard');
$router->get('admin/users', AdminController::class, 'users');
$router->get('admin/edit-user', AdminController::class, 'editUser');
$router->post('admin/edit-user', AdminController::class, 'editUser');
$router->post('admin/delete-user', AdminController::class, 'deleteUser');


$router->dispatch(); 