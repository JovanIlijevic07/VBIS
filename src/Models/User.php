<?php

namespace App\Models;

use App\Core\Database;

class User
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // Login po username ili email
    public function login($usernameOrEmail, $password)
    {
        $stmt = $this->db->query(
            "SELECT * FROM users WHERE username = ? OR email = ?",
            [$usernameOrEmail, $usernameOrEmail]
        );
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }

        return false;
    }

    // Registracija korisnika
    public function register($username, $password, $email, $isAdmin = 0)
    {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $this->db->query(
            "INSERT INTO users (username, password, email, is_admin) VALUES (?, ?, ?, ?)",
            [$username, $hashedPassword, $email, $isAdmin]
        );

        $id = $this->db->getConnection()->lastInsertId();

        return [
            'id' => $id,
            'username' => $username,
            'email' => $email,
            'is_admin' => $isAdmin
        ];
    }

    // Vrati korisnika po ID
    public function findById($id)
    {
        $stmt = $this->db->query("SELECT * FROM users WHERE id = ?", [$id]);
        return $stmt->fetch();
    }

    // Lista svih običnih korisnika (za admin dashboard)
    public function getAllUsers()
    {
        $stmt = $this->db->query("SELECT id, username, email, is_admin FROM users WHERE is_admin = 0");
        return $stmt->fetchAll();
    }

    // Delete korisnika (samo obični korisnici)
    public function deleteUser($id)
    {
        $this->db->query("DELETE FROM users WHERE id = ? AND is_admin = 0", [$id]);
        return true;
    }

    // Update korisnika (samo obični korisnici)
    public function updateUser($id, $data)
    {
        $fields = [];
        $values = [];

        foreach ($data as $key => $value) {
            $fields[] = "$key = ?";
            $values[] = $value;
        }

        $values[] = $id;

        $sql = "UPDATE users SET " . implode(", ", $fields) . " WHERE id = ? AND is_admin = 0";
        $this->db->query($sql, $values);

        return true;
    }

    // Statistika korisnika (bez created_at)
    public function getUserStats()
    {
        $stmt = $this->db->query("SELECT COUNT(*) as total_users FROM users WHERE is_admin = 0");
        $total = $stmt->fetch()['total_users'] ?? 0;

        // Bez created_at kolone, new_users_today postavljamo na 0
        $newToday = 0;

        return [
            'total_users' => $total,
            'new_users_today' => $newToday
        ];
    }
}
