<?php

namespace App\Models;

use App\Core\Model;

class Product extends Model
{
    /**
     * Get all products with category information
     * 
     * @param int $limit Number of products to retrieve
     * @param int $offset Offset for pagination
     * @param string $orderBy Column to sort by
     * @param string $direction Sort direction (ASC or DESC)
     * @return array
     */
    public function getAll($limit = null, $offset = 0, $orderBy = 'created_at', $direction = 'DESC')
    {
        // Validate orderBy parameter
        $allowedColumns = ['id', 'productname', 'brand', 'price', 'quantity', 'upvotes', 'created_at', 'updated_at'];
        if (!in_array($orderBy, $allowedColumns)) {
            $orderBy = 'created_at';
        }
        
        // Validate direction parameter
        $direction = strtoupper($direction);
        if ($direction !== 'ASC' && $direction !== 'DESC') {
            $direction = 'DESC';
        }
        
        $sql = "SELECT p.*, c.name as category_name, c.slug as category_slug 
                FROM products p 
                JOIN categories c ON p.category_id = c.id 
                ORDER BY p.{$orderBy} {$direction}";
        
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
     * Get products by category ID
     * 
     * @param int $categoryId Category ID
     * @param int $limit Number of products to retrieve
     * @param int $offset Offset for pagination
     * @param string $orderBy Column to sort by
     * @param string $direction Sort direction (ASC or DESC)
     * @return array
     */
    public function getByCategoryId($categoryId, $limit = null, $offset = 0, $orderBy = 'created_at', $direction = 'DESC')
    {
        // Validate orderBy parameter
        $allowedColumns = ['id', 'productname', 'brand', 'price', 'quantity', 'upvotes', 'created_at', 'updated_at'];
        if (!in_array($orderBy, $allowedColumns)) {
            $orderBy = 'created_at';
        }
        
        // Validate direction parameter
        $direction = strtoupper($direction);
        if ($direction !== 'ASC' && $direction !== 'DESC') {
            $direction = 'DESC';
        }
        
        $sql = "SELECT p.*, c.name as category_name, c.slug as category_slug 
                FROM products p 
                JOIN categories c ON p.category_id = c.id 
                WHERE p.category_id = :categoryId 
                ORDER BY p.{$orderBy} {$direction}";
        
        if ($limit !== null) {
            $sql .= " LIMIT :limit OFFSET :offset";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':categoryId', (int)$categoryId, \PDO::PARAM_INT);
            $stmt->bindValue(':limit', (int)$limit, \PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int)$offset, \PDO::PARAM_INT);
            $stmt->execute();
        } else {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':categoryId', (int)$categoryId, \PDO::PARAM_INT);
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
    public function getById($id)
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
     * Get product by name and category ID
     * 
     * @param string $name Product name
     * @param int $categoryId Category ID
     * @return array|null
     */
    public function getByNameAndCategory($name, $categoryId)
    {
        $sql = "SELECT p.*, c.name as category_name, c.slug as category_slug 
                FROM products p 
                JOIN categories c ON p.category_id = c.id 
                WHERE p.productname = :name AND p.category_id = :categoryId";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'name' => $name,
            'categoryId' => $categoryId
        ]);
        return $stmt->fetch();
    }

    /**
     * Search products by name
     * 
     * @param string $search Search term
     * @param int $limit Number of products to retrieve
     * @param int $offset Offset for pagination
     * @param string $orderBy Column to sort by
     * @param string $direction Sort direction (ASC or DESC)
     * @return array
     */
    public function searchByName($search, $limit = null, $offset = 0, $orderBy = 'created_at', $direction = 'DESC')
    {
        // Validate orderBy parameter
        $allowedColumns = ['id', 'productname', 'brand', 'price', 'quantity', 'upvotes', 'created_at', 'updated_at'];
        if (!in_array($orderBy, $allowedColumns)) {
            $orderBy = 'created_at';
        }
        
        // Validate direction parameter
        $direction = strtoupper($direction);
        if ($direction !== 'ASC' && $direction !== 'DESC') {
            $direction = 'DESC';
        }
        
        $sql = "SELECT p.*, c.name as category_name, c.slug as category_slug 
                FROM products p 
                JOIN categories c ON p.category_id = c.id 
                WHERE p.productname LIKE :search 
                ORDER BY p.{$orderBy} {$direction}";
        
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
     * Get hottest products (ordered by upvotes)
     * 
     * @param int $limit Number of products to retrieve
     * @return array
     */
    public function getHottest($limit = 6)
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
     * Create a new product
     * 
     * @param array $data Product data
     * @return bool
     */
    public function create($data)
    {
        return $this->insert('products', $data);
    }

    /**
     * Update a product
     * 
     * @param int $id Product ID
     * @param array $data Product data
     * @return bool
     */
    public function updateProduct($id, $data)
    {
        return parent::update('products', $data, 'id = :id', ['id' => $id]);
    }

    /**
     * Delete a product
     * 
     * @param int $id Product ID
     * @return bool
     */
    public function deleteProduct($id)
    {
        return parent::delete('products', 'id = :id', ['id' => $id]);
    }

    /**
     * Increment upvotes for a product
     * 
     * @param int $id Product ID
     * @return bool
     */
    public function incrementUpvotes($id)
    {
        $sql = "UPDATE products SET upvotes = upvotes + 1 WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    /**
     * Get count of all products
     * 
     * @return int
     */
    public function getCount()
    {
        $sql = "SELECT COUNT(*) as count FROM products";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['count'];
    }

    /**
     * Get count of products in a category
     * 
     * @param int $categoryId Category ID
     * @return int
     */
    public function getCountByCategory($categoryId)
    {
        $sql = "SELECT COUNT(*) as count FROM products WHERE category_id = :categoryId";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['categoryId' => $categoryId]);
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

    /**
     * Get tags for this product
     * 
     * @param int $productId Product ID
     * @return array
     */
    public function getTags($productId)
    {
        $productTagModel = new ProductTag();
        return $productTagModel->getTagsForProduct($productId);
    }

    /**
     * Attach tags to this product
     * 
     * @param int $productId Product ID
     * @param array $tagIds Array of tag IDs
     * @return void
     */
    public function attachTags($productId, $tagIds)
    {
        $productTagModel = new ProductTag();
        foreach ($tagIds as $tagId) {
            $productTagModel->attachTag($productId, $tagId);
        }
    }

    /**
     * Detach tags from this product
     * 
     * @param int $productId Product ID
     * @param array $tagIds Array of tag IDs
     * @return void
     */
    public function detachTags($productId, $tagIds)
    {
        $productTagModel = new ProductTag();
        foreach ($tagIds as $tagId) {
            $productTagModel->detachTag($productId, $tagId);
        }
    }

    /**
     * Sync tags for this product (remove old, add new)
     * 
     * @param int $productId Product ID
     * @param array $tagIds Array of tag IDs
     * @return void
     */
    public function syncTags($productId, $tagIds)
    {
        $productTagModel = new ProductTag();
        // Remove all existing tags
        $productTagModel->detachAllTags($productId);
        // Add new tags
        $this->attachTags($productId, $tagIds);
    }

    /**
     * Get database connection
     * 
     * @return 
     */
    public function getConnection()
    {
        return $this->db;
    }
} 