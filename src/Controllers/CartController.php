<?php
namespace App\Controllers;

use App\Models\Cart;
use App\Models\Movie;
use App\Models\Order;
use App\Core\Session;

class CartController
{
    private $cartModel;

    public function __construct()
    {
        $this->cartModel = new Cart();
    }
    public function update()
{
    $movieId = $_POST['id'] ?? null;
    $change = $_POST['change'] ?? null;

    if ($movieId && $change) {
        $items = $this->cartModel->getCartItems();

        foreach ($items as $item) {
            if ($item['id'] == $movieId) {
                $quantity = $item['quantity'];
                if ($change === 'plus') $quantity++;
                if ($change === 'minus') $quantity--;
                $this->cartModel->updateQuantity($movieId, $quantity);
                break;
            }
        }
    }

    header("Location: /cart");
    exit;
}

public function remove()
{
    $movieId = $_POST['id'] ?? null;

    if ($movieId) {
        $this->cartModel->removeItem($movieId);
    }

    header("Location: /cart");
    exit;
}



    public function index()
    {
        $items = $this->cartModel->getCartItems();
        include __DIR__ . '/../Views/users/cart.php';
    }

    public function add()
{
    $movieId = $_POST['movie_id'] ?? null;
    $quantity = $_POST['quantity'] ?? 1;

    if ($movieId) {
        $movieModel = new Movie();
        $movie = $movieModel->getMovieById($movieId);

        if ($movie) {
            $this->cartModel->addItem($movie, $quantity);
        }
    }

    header("Location: /cart");
    exit;
}


    public function buy()
    {
        $items = $this->cartModel->getCartItems();

        if (empty($items)) {
            header("Location: /cart");
            exit;
        }

        $userId = Session::get('user_id');
        if (!$userId) {
            header("Location: /login");
            exit;
        }

        $orderModel = new Order();
        $orderModel->createOrderWithItems($userId, $items);

        $this->cartModel->clear();

        header("Location: /orders");
        exit;
    }
}
