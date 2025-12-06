<?php

namespace App\Models;

use App\Core\Model;

class Category extends Model
{
    /**
     * Get all categories with optional sorting
     * 
     * @param string $orderBy Column to sort by
     * @param string $direction Sort direction (ASC or DESC)
     * @return array
     */
    public function getAll($orderBy = 'id', $direction = 'ASC')
    {
        // Validate orderBy parameter
        $allowedColumns = ['id', 'name', 'slug', 'created_at', 'updated_at'];
        if (!in_array($orderBy, $allowedColumns)) {
            $orderBy = 'id';
        }
        
        // Validate direction parameter
        $direction = strtoupper($direction);
        if ($direction !== 'ASC' && $direction !== 'DESC') {
            $direction = 'ASC';
        }
        
        $sql = "SELECT * FROM categories ORDER BY {$orderBy} {$direction}";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Get category by ID
     * 
     * @param int $id Category ID
     * @return array|null
     */
    public function getById($id)
    {
        $sql = "SELECT * FROM categories WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Get category by slug
     * 
     * @param string $slug Category slug
     * @return array|null
     */
    public function getBySlug($slug)
    {
        $sql = "SELECT * FROM categories WHERE slug = :slug";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['slug' => $slug]);
        return $stmt->fetch();
    }

    /**
     * Create a new category
     * 
     * @param array $data Category data
     * @return bool
     */
    public function create($data)
    {
        // Generate slug from name if not provided
        if (!isset($data['slug']) && isset($data['name'])) {
            $data['slug'] = $this->generateSlug($data['name']);
        }
        
        return $this->insert('categories', $data);
    }

    /**
     * Update a category
     * 
     * @param int $id Category ID
     * @param array $data Category data
     * @return bool
     */
    public function updateCategory($id, $data)
    {
        // Generate slug from name if provided
        if (isset($data['name']) && !isset($data['slug'])) {
            $data['slug'] = $this->generateSlug($data['name']);
        }
        
        return parent::update('categories', $data, 'id = :id', ['id' => $id]);
    }

    /**
     * Delete a category
     * 
     * @param int $id Category ID
     * @return bool
     */
    public function deleteCategory($id)
    {
        return parent::delete('categories', 'id = :id', ['id' => $id]);
    }

    /**
     * Get total number of categories
     * 
     * @return int
     */
    public function getTotalCategories()
    {
        $sql = "SELECT COUNT(*) as count FROM categories";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['count'];
    }

    /**
     * Search categories by name
     * 
     * @param string $search Search term
     * @param string $orderBy Column to sort by
     * @param string $direction Sort direction (ASC or DESC)
     * @return array
     */
    public function searchByName($search, $orderBy = 'name', $direction = 'ASC')
    {
        // Validate orderBy parameter
        $allowedColumns = ['id', 'name', 'slug', 'created_at', 'updated_at'];
        if (!in_array($orderBy, $allowedColumns)) {
            $orderBy = 'name';
        }
        
        // Validate direction parameter
        $direction = strtoupper($direction);
        if ($direction !== 'ASC' && $direction !== 'DESC') {
            $direction = 'ASC';
        }
        
        $sql = "SELECT * FROM categories WHERE name LIKE :search ORDER BY {$orderBy} {$direction}";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':search', "%{$search}%");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Generate a URL-friendly slug from a string
     * 
     * @param string $text Input text
     * @return string
     */
    private function generateSlug($text)
    {
        // Replace non-letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        
        // Transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        
        // Remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);
        
        // Trim
        $text = trim($text, '-');
        
        // Remove duplicate -
        $text = preg_replace('~-+~', '-', $text);
        
        // Lowercase
        $text = strtolower($text);
        
        if (empty($text)) {
            return 'n-a';
        }
        
        return $text;
    }
}