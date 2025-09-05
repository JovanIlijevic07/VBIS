<?php
namespace App\Models;

class Cart
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    public function addItem($movie, $quantity = 1)
{
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $movie['id']) {
            $item['quantity'] += $quantity;
            return;
        }
    }

    $_SESSION['cart'][] = [
        'id' => $movie['id'],
        'title' => $movie['title'],
        'price' => $movie['price'],
        'quantity' => $quantity,
        'image_url' => $movie['image_url']
    ];
}


    public function updateQuantity($movieId, $quantity)
    {
      
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] == $movieId) {
                
            
                if ($quantity <= 0) {
                    $this->removeItem($movieId);
                } else {
                    $item['quantity'] = $quantity;
                }
                return;
            }
        }
    }

  
    public function removeItem($movieId)
    {
        foreach ($_SESSION['cart'] as $key => $item) {
            if ($item['id'] == $movieId) {
                unset($_SESSION['cart'][$key]);
                $_SESSION['cart'] = array_values($_SESSION['cart']); 
                return;
            }
        }
    }


    public function getCartItems()
    {
        return $_SESSION['cart'];
    }

    public function clear()
    {
        $_SESSION['cart'] = [];
    }
}
