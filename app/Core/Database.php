<?php

namespace App\Core;

use PDO;

class Database
{
    private static $instance = null;
    private $connection;

    private function __construct()
    {
        $this->connect();
    }

    /**
     * Get the singleton instance
     * 
     * @return Database
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }

        return self::$instance;
    }

    /**
     * Connect to the database
     * 
     * @return void
     */
    private function connect()
    {
        // Try to get environment variables using $_SERVER first, then getenv()
        $host = $_SERVER['DB_HOST'] ?? getenv('DB_HOST') ;
        $db_name = $_SERVER['DB_NAME'] ?? getenv('DB_NAME') ;
        $username = $_SERVER['DB_USER'] ?? getenv('DB_USER') ;
        $password = $_SERVER['DB_PASSWORD'] ?? getenv('DB_PASSWORD') ;

        

        try {
            $dsn = "mysql:host={$host};dbname={$db_name};charset=utf8mb4";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];

            $this->connection = new PDO($dsn, $username, $password, $options);
        } catch (\PDOException $e) {
            throw new \Exception("Database connection failed: " . $e->getMessage());
        }
    }

    /**
     * Get the database connection
     * 
     * @return PDO
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * Prevent cloning
     * 
     * @return void
     */
    private function __clone()
    {
    }

    /**
     * Prevent unserialization
     * 
     * @return void
     */
    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize singleton");
    }
}