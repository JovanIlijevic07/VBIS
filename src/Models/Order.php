<?php

namespace App\Models;

class Order
{
    private static $orders = [
        1 => ['id' => 1, 'user_id' => 2, 'movie_id' => 1, 'price' => 9.99, 'created_at' => '2024-01-10'],
        2 => ['id' => 2, 'user_id' => 2, 'movie_id' => 3, 'price' => 11.99, 'created_at' => '2024-01-12'],
        3 => ['id' => 3, 'user_id' => 3, 'movie_id' => 2, 'price' => 12.99, 'created_at' => '2024-01-15']
    ];
    
    public function createOrder($userId, $movieId, $price)
    {
        $id = max(array_keys(self::$orders)) + 1;
        $order = [
            'id' => $id,
            'user_id' => $userId,
            'movie_id' => $movieId,
            'price' => $price,
            'created_at' => date('Y-m-d H:i:s')
        ];
        self::$orders[$id] = $order;
        return $order;
    }
    
    public function getUserOrders($userId)
    {
        return array_filter(self::$orders, function($order) use ($userId) {
            return $order['user_id'] == $userId;
        });
    }
    
    public function getAllOrders()
    {
        return self::$orders;
    }
    
    public function getOrderStats()
    {
        $totalRevenue = array_sum(array_column(self::$orders, 'price'));
        $todayOrders = array_filter(self::$orders, function($order) {
            return date('Y-m-d', strtotime($order['created_at'])) === date('Y-m-d');
        });
        
        return [
            'total_orders' => count(self::$orders),
            'total_revenue' => round($totalRevenue, 2),
            'orders_today' => count($todayOrders),
            'revenue_today' => round(array_sum(array_column($todayOrders, 'price')), 2)
        ];
    }
}