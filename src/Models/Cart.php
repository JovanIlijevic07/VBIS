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

    public function addItem($movie)
{
    // Proveri da li je film već u korpi
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $movie['id']) {
            $item['quantity']++;
            return;
        }
    }

    // Dodaj film u korpu sa slikom
    $_SESSION['cart'][] = [
        'id' => $movie['id'],
        'title' => $movie['title'],
        'price' => $movie['price'],
        'quantity' => 1,
        'image_url' => $movie['image_url']  // fallback ako nema slike
    ];
}

public function updateQuantity($movieId, $quantity)
{
    // Ako nema kartice, ne radi ništa
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $movieId) {
            // Ako je quantity <= 0, možeš obrisati stavku
            if ($quantity <= 0) {
                $this->removeItem($movieId);
            } else {
                $item['quantity'] = $quantity;
            }
            return;
        }
    }
}

// metoda za brisanje stavke
public function removeItem($movieId)
{
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['id'] == $movieId) {
            unset($_SESSION['cart'][$key]);
            $_SESSION['cart'] = array_values($_SESSION['cart']); // reset indexe
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
