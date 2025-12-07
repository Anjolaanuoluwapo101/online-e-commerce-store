<?php

namespace App\Core;

use PDO;

class Migration
{
    private $db;

    public function __construct()
    {
        // Try to get connection, if it fails, create database first
        try {
            $this->db = Database::getInstance()->getConnection();
        } catch (\Exception $e) {
            // Create database if it doesn't exist
            $this->createDatabase();
            $this->db = Database::getInstance()->getConnection();
        }
    }

    /**
     * Create the database if it doesn't exist
     * 
     * @return void
     */
    private function createDatabase()
    {
        $host = 'sql3.freesqldatabase.com';
        $db_name = 'sql3807573';
        $username = 'sql3807573';
        $password = 'DjsYBc6Dv9';

        try {
            $dsn = "mysql:host={$host}";
            $pdo = new PDO($dsn, $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $pdo->exec("CREATE DATABASE IF NOT EXISTS {$db_name}");
            echo "Database created successfully\n";
        } catch (\PDOException $e) {
            throw new \Exception("Database creation failed: " . $e->getMessage());
        }
    }

    /**
     * Create the categories table
     * 
     * @return void
     */
    public function createCategoriesTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS categories (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(150) NOT NULL UNIQUE,
            slug VARCHAR(191) NOT NULL UNIQUE,
            description TEXT,
            created_at TIMESTAMP DEFAULT NOW()
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

        $this->db->exec($sql);
    }

    /**
     * Create the products table
     * 
     * @return void
     */
    public function createProductsTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS products (
            id INT AUTO_INCREMENT PRIMARY KEY,
            category_id INT NOT NULL,
            productname VARCHAR(150) NOT NULL,
            brand VARCHAR(150),
            price DECIMAL(10, 2) NOT NULL,
            quantity INT NOT NULL DEFAULT 0,
            imagepath VARCHAR(150),
            description TEXT,
            upvotes INT DEFAULT 0,
            created_at TIMESTAMP DEFAULT NOW(),
            FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE,
            UNIQUE KEY unique_product_category (productname, category_id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

        $this->db->exec($sql);
    }

    /**
     * Create the tags table
     * 
     * @return void
     */
    public function createTagsTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS tags (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(150) NOT NULL UNIQUE,
            slug VARCHAR(191) NOT NULL UNIQUE,
            description TEXT,
            created_at TIMESTAMP DEFAULT NOW()
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

        $this->db->exec($sql);
    }

    /**
     * Create the product_tags table for many-to-many relationship
     * 
     * @return void
     */
    public function createProductTagsTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS product_tags (
            id INT AUTO_INCREMENT PRIMARY KEY,
            product_id INT NOT NULL,
            tag_id INT NOT NULL,
            FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
            FOREIGN KEY (tag_id) REFERENCES tags(id) ON DELETE CASCADE,
            UNIQUE KEY unique_product_tag (product_id, tag_id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

        $this->db->exec($sql);
    }

    /*
     * Create Orders table
     * 
     * @return void
     */
    public function createOrdersTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS orders (
            id INT AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(150) NOT NULL,
            total_amount DECIMAL(15, 2) NOT NULL, 
            cart_data LONGTEXT NULL,
            status ENUM('pending', 'processing', 'completed', 'cancelled') DEFAULT 'pending',
            payment_status ENUM('unpaid','paid','refund') DEFAULT 'unpaid',
            created_at TIMESTAMP DEFAULT NOW()
        );";
        $this->db->exec($sql);
    }

    /*
     * Create Payment table
     * 
     * @return void
     */
    public function createPaymentsTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS payments (
            id INT AUTO_INCREMENT PRIMARY KEY,
            
            -- Link it to the specific order
            order_id INT NOT NULL, 
            
            -- The Critical Paystack Reference (Must be Unique)
            reference VARCHAR(50) UNIQUE NOT NULL, 
            
            -- Amount attempted in this specific transaction
            amount DECIMAL(15, 2) NOT NULL, 
            
            -- 'pending' = User sent to Paystack
            -- 'success' = Paystack verified money received
            -- 'failed'  = Card declined / Bank error
            status ENUM('unpaid','paid','refund') DEFAULT 'unpaid',
            
            -- Store the raw response  from Paystack (for debugging)
            gateway_response VARCHAR(150) NULL, 
            
            -- Channel used (card, bank, ussd) - for analytics
            channel VARCHAR(20) NULL, 
            
            paid_at TIMESTAMP NULL,
            created_at TIMESTAMP DEFAULT NOW(),

            FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
            INDEX(reference)
        );";
        $this->db->exec($sql);
    }

    
    /**
     * Create all tables
     * 
     * @return void
     */
    public function createTables()
    {
        $this->createCategoriesTable();
        $this->createProductsTable();
        $this->createTagsTable();
        $this->createProductTagsTable();
        $this->createOrdersTable();
        $this->createPaymentsTable();
    }

    /**
     * Seed initial categories
     * 
     * @return void
     */
    public function seedCategories()
    {
        $categories = [
            ['name' => 'Wristwatches', 'slug' => 'wristwatches', 'description' => 'Collection of wristwatches'],
            ['name' => 'Bags', 'slug' => 'bags', 'description' => 'Collection of bags']
        ];

        foreach ($categories as $category) {
            $sql = "INSERT IGNORE INTO categories (name, slug, description) VALUES (:name, :slug, :description)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute($category);
        }
    }

    /**
     * Run all migrations
     * 
     * @return void
     */
    public function migrate()
    {
        $this->createTables();
        $this->seedCategories();
    }

    /**
     * Drop all tables
     * 
     * @return void
     */
    public function dropTables()
    {
        $tables = ['payments', 'orders', 'product_tags', 'products', 'categories', 'tags'];
        
        foreach ($tables as $table) {
            try {
                $sql = "DROP TABLE IF EXISTS {$table}";
                $this->db->exec($sql);
            } catch (\Exception $e) {
                error_log("Error dropping table {$table}: " . $e->getMessage());
            }
        }
    }
}