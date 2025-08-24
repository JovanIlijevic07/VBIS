<?php

namespace App\Models;

use App\Core\Database;

class User
{
    private $db;
    private static $users = [
        1 => ['id' => 1, 'username' => 'admin', 'password' => 'admin123', 'email' => 'admin@moviestore.com', 'role' => 'admin', 'created_at' => '2024-01-01'],
        2 => ['id' => 2, 'username' => 'john_doe', 'password' => 'password123', 'email' => 'john@example.com', 'role' => 'user', 'created_at' => '2024-01-02'],
        3 => ['id' => 3, 'username' => 'jane_smith', 'password' => 'password456', 'email' => 'jane@example.com', 'role' => 'user', 'created_at' => '2024-01-03']
    ];
    
    public function __construct()
    {
        $this->db = new Database();
    }
    
    public function login($username, $password)
    {
        foreach (self::$users as $user) {
            if ($user['username'] === $username && $user['password'] === $password) {
                return $user;
            }
        }
        return false;
    }
    
    public function register($username, $password, $email)
    {
        $id = max(array_keys(self::$users)) + 1;
        $user = [
            'id' => $id,
            'username' => $username,
            'password' => $password,
            'email' => $email,
            'role' => 'user',
            'created_at' => date('Y-m-d')
        ];
        self::$users[$id] = $user;
        return $user;
    }
    
    public function findById($id)
    {
        return self::$users[$id] ?? false;
    }
    
    public function getAllUsers()
    {
        return array_filter(self::$users, function($user) {
            return $user['role'] !== 'admin';
        });
    }
    
    public function deleteUser($id)
    {
        if (isset(self::$users[$id]) && self::$users[$id]['role'] !== 'admin') {
            unset(self::$users[$id]);
            return true;
        }
        return false;
    }
    
    public function updateUser($id, $data)
    {
        if (isset(self::$users[$id]) && self::$users[$id]['role'] !== 'admin') {
            self::$users[$id] = array_merge(self::$users[$id], $data);
            return true;
        }
        return false;
    }
    
    public function getUserStats()
    {
        return [
            'total_users' => count(array_filter(self::$users, function($user) {
                return $user['role'] !== 'admin';
            })),
            'new_users_today' => count(array_filter(self::$users, function($user) {
                return $user['created_at'] === date('Y-m-d') && $user['role'] !== 'admin';
            }))
        ];
    }
}