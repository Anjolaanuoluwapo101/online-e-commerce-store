<?php

namespace App\Models;

use App\Core\Model;

class ProductManager extends Model
{
    /**
     * Get all products from all categories
     * 
     * @param int $limit Number of products to retrieve
     * @param int $offset Offset for pagination
     * @return array
     */
    public function getAllProducts($limit = null, $offset = 0)
    {
        $sql = "SELECT p.*, c.name as category_name, c.slug as category_slug 
                FROM products p 
                JOIN categories c ON p.category_id = c.id 
                ORDER BY p.created_at DESC";
        
        if ($limit !== null) {
            $sql .= " LIMIT :limit OFFSET :offset";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':limit', (int)$limit, \PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int)$offset, \PDO::PARAM_INT);
            $stmt->execute();
        } else {
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
        }
        
        return $stmt->fetchAll();
    }

    /**
     * Get hottest products from all categories (ordered by upvotes)
     * 
     * @param int $limit Number of products to retrieve
     * @return array
     */
    public function getHottestProducts($limit = 6)
    {
        $sql = "SELECT p.*, c.name as category_name, c.slug as category_slug 
                FROM products p 
                JOIN categories c ON p.category_id = c.id 
                ORDER BY p.upvotes DESC 
                LIMIT :limit";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Search products by name in all categories
     * 
     * @param string $search Search term
     * @param int $limit Number of products to retrieve
     * @param int $offset Offset for pagination
     * @return array
     */
    public function searchProducts($search, $limit = null, $offset = 0)
    {
        $sql = "SELECT p.*, c.name as category_name, c.slug as category_slug 
                FROM products p 
                JOIN categories c ON p.category_id = c.id 
                WHERE p.productname LIKE :search 
                ORDER BY p.created_at DESC";
        
        if ($limit !== null) {
            $sql .= " LIMIT :limit OFFSET :offset";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':search', "%{$search}%");
            $stmt->bindValue(':limit', (int)$limit, \PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int)$offset, \PDO::PARAM_INT);
            $stmt->execute();
        } else {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':search', "%{$search}%");
            $stmt->execute();
        }
        
        return $stmt->fetchAll();
    }

    /**
     * Get product by ID
     * 
     * @param int $id Product ID
     * @return array|null
     */
    public function getProductById($id)
    {
        $sql = "SELECT p.*, c.name as category_name, c.slug as category_slug 
                FROM products p 
                JOIN categories c ON p.category_id = c.id 
                WHERE p.id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Get count of all products
     * 
     * @return int
     */
    public function getTotalCount()
    {
        $sql = "SELECT COUNT(*) as count FROM products";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['count'];
    }

    /**
     * Get count of products matching search
     * 
     * @param string $search Search term
     * @return int
     */
    public function getSearchCount($search)
    {
        $sql = "SELECT COUNT(*) as count FROM products WHERE productname LIKE :search";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':search', "%{$search}%");
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['count'];
    }
}