<?php
namespace Models;

use Core\Database;

class OrderItem
{
    public static function create($orderId, $movieId, $quantity, $price)
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("INSERT INTO order_items (order_id, movie_id, quantity, price) VALUES (?, ?, ?, ?)");
        $stmt->execute([$orderId, $movieId, $quantity, $price]);
    }
}
