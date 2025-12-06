<?php

namespace App\Models;

use App\Core\Model;

class Tag extends Model
{
    /**
     * Get all tags
     * 
     * @return array
     */
    public function getAll()
    {
        $sql = "SELECT * FROM tags ORDER BY name ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Get tag by ID
     * 
     * @param int $id Tag ID
     * @return array|null
     */
    public function getById($id)
    {
        $sql = "SELECT * FROM tags WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Get tag by slug
     * 
     * @param string $slug Tag slug
     * @return array|null
     */
    public function getBySlug($slug)
    {
        $sql = "SELECT * FROM tags WHERE slug = :slug";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['slug' => $slug]);
        return $stmt->fetch();
    }

    /**
     * Get tags by product ID
     * 
     * @param int $productId Product ID
     * @return array
     */
    public function getByProductId($productId)
    {
        $sql = "SELECT t.* FROM tags t 
                JOIN product_tags pt ON t.id = pt.tag_id 
                WHERE pt.product_id = :productId";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['productId' => $productId]);
        return $stmt->fetchAll();
    }

    /**
     * Create a new tag
     * 
     * @param array $data Tag data
     * @return bool
     */
    public function create($data)
    {
        // Generate slug from name if not provided
        if (!isset($data['slug']) && isset($data['name'])) {
            $data['slug'] = $this->generateSlug($data['name']);
        }
        
        return $this->insert('tags', $data);
    }

    /**
     * Update a tag
     * 
     * @param int $id Tag ID
     * @param array $data Tag data
     * @return bool
     */
    public function updateTag($id, $data)
    {
        return parent::update('tags', $data, 'id = :id', ['id' => $id]);
    }

    /**
     * Delete a tag
     * 
     * @param int $id Tag ID
     * @return bool
     */
    public function deleteTag($id)
    {
        return parent::delete('tags', 'id = :id', ['id' => $id]);
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