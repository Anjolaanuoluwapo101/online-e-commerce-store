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
     * Connect to the PostgreSQL database
     * 
     * @return void
     */
    private function connect()
    {
        // Try to get environment variables using $_SERVER first, then getenv()
        $host = $_SERVER['DB_HOST'] ?? getenv('DB_HOST') ?? 'localhost';
        $db_name = $_SERVER['DB_NAME'] ?? getenv('DB_NAME') ?? 'postgres';
        $username = $_SERVER['DB_USER'] ?? getenv('DB_USER') ?? 'postgres';
        $password = $_SERVER['DB_PASSWORD'] ?? getenv('DB_PASSWORD') ?? '';
        $port = $_SERVER['DB_PORT'] ?? getenv('DB_PORT') ?? '5432';
        $sslmode = $_SERVER['DB_SSLMODE'] ?? getenv(name: 'DB_SSLMODE') ?? 'require';


        try {
            // PostgreSQL DSN format
            $dsn = "pgsql:host={$host};port={$port};dbname={$db_name};sslmode={$sslmode}";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => true, // 
                PDO::ATTR_PERSISTENT => false, // Changed to false for better connection management
            ];

            $this->connection = new PDO($dsn, $username, $password, $options);
            
            // Test the connection
            // $this->connection->query('SELECT 1');
            
        } catch (\PDOException $e) {
            error_log("PostgreSQL database connection failed: " . $e->getMessage());
            throw new \Exception("Database connection failed: " . $e->getMessage() . ". Please verify your database credentials and ensure the database '{$db_name}' exists on host '{$host}:{$port}'");
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