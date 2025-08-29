<?php

namespace App\Models;

use App\Core\Database; 

class Order
{
    public $db;

    public function __construct()
    {
        $this->db = new Database();
    }
    
    public function createOrderWithItems($userId, $cartItems)
{
    try {
        $conn = $this->db->getConnection();
        $conn->beginTransaction();

        // Izračunaj ukupan iznos
        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // 1. Kreiraj order
        $stmt = $this->db->query(
            "INSERT INTO orders (user_id, total_amount, order_date) VALUES (?, ?, NOW())",
            [$userId, $total]
        );
        $orderId = $conn->lastInsertId();

        // 2. Dodaj sve filmove u order_items
        foreach ($cartItems as $item) {
            $this->db->query(
                "INSERT INTO order_items (order_id, movie_id, quantity, price) VALUES (?, ?, ?, ?)",
                [$orderId, $item['id'], $item['quantity'], $item['price']]
            );
        }

        $conn->commit();
        return $orderId;
    } catch (\Exception $e) {
        $conn->rollBack();
        throw $e;
    }
}

public function getSoldByGenre()
{
    $stmt = $this->db->query("
        SELECT m.genre, SUM(oi.quantity) as total_sold
        FROM order_items oi
        JOIN movies m ON oi.movie_id = m.id
        GROUP BY m.genre
    ");
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}


public function getDailyRevenueLast30Days()
{
    $stmt = $this->db->query("
        SELECT DATE(order_date) as day, SUM(total_amount) as revenue
        FROM orders
        WHERE order_date >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
        GROUP BY DATE(order_date)
        ORDER BY day ASC
    ");
    $rows = $stmt->fetchAll();

    $revenues = [];
    foreach ($rows as $row) {
        $revenues[$row['day']] = (float)$row['revenue'];
    }

    return $revenues;
}


    // Vrati narudžbine korisnika
    public function getUserOrders($userId)
    {
        $stmt = $this->db->query(
            "SELECT o.id as order_id, o.order_date, o.total_amount,
                    oi.movie_id, oi.quantity, oi.price
             FROM orders o
             JOIN order_items oi ON o.id = oi.order_id
             WHERE o.user_id = ?
             ORDER BY o.order_date DESC",
            [$userId]
        );
        return $stmt->fetchAll();
    }

    // Vrati sve narudžbine
    public function getAllOrders()
    {
        $stmt = $this->db->query(
            "SELECT o.id as order_id, o.user_id, o.order_date, o.total_amount,
                    oi.movie_id, oi.quantity, oi.price
             FROM orders o
             JOIN order_items oi ON o.id = oi.order_id
             ORDER BY o.order_date DESC"
        );
        return $stmt->fetchAll();
    }

  public function getOrderStats()
{
    $stats = [];

    // Ukupan broj porudžbina
    $stmt = $this->db->query("SELECT COUNT(*) as total FROM orders");
    $stats['total_orders'] = $stmt->fetch()['total'];

    // Ukupan prihod
    $stmt = $this->db->query("SELECT SUM(total_amount) as revenue FROM orders");
    $stats['total_revenue'] = round($stmt->fetch()['revenue'] ?? 0, 2);

    // Današnje narudžbine
    $stmt = $this->db->query("SELECT COUNT(*) as today_orders, SUM(total_amount) as today_revenue 
                               FROM orders WHERE DATE(order_date) = CURDATE()");
    $row = $stmt->fetch();
    $stats['orders_today'] = $row['today_orders'] ?? 0;
    $stats['revenue_today'] = round($row['today_revenue'] ?? 0, 2);

    // 📊 Zarada po mesecima za line chart
    $stmt = $this->db->query("
        SELECT DATE_FORMAT(order_date, '%Y-%m') as month, SUM(total_amount) as revenue
        FROM orders
        GROUP BY DATE_FORMAT(order_date, '%Y-%m')
        ORDER BY month ASC
    ");
    $revenues = $stmt->fetchAll();

    $latestRevenue = [];
    foreach ($revenues as $row) {
        $latestRevenue[$row['month']] = (float)$row['revenue'];
    }
    $stats['latest_revenue'] = $latestRevenue;

    return $stats;
}

}