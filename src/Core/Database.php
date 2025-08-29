<?php

namespace App\Core;

class Database
{
    private $host = 'localhost';
    private $dbname = 'movie_store';
    private $username = 'root';
    private $password = 'root'; 
    private $pdo;

    public function __construct()
    {
        try {
            $this->pdo = new \PDO(
                "mysql:host={$this->host};dbname={$this->dbname};charset=utf8",
                $this->username,
                $this->password,
                [
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
                ]
            );
        } catch (\PDOException $e) {
            // Loguj grešku i prikaži je u developmentu
            error_log("DB connection failed: " . $e->getMessage());
            $this->pdo = null;
        }
    }

    public function getConnection()
    {
        return $this->pdo;
    }

    public function query($sql, $params = [])
    {
        if ($this->pdo) {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        }
        return false;
    }
}

