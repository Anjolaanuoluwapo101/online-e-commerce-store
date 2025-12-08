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
     * Get tag by name (case insensitive)
     * 
     * @param string $name Tag name
     * @return array|null
     */
    public function getByName($name)
    {
        $sql = "SELECT * FROM tags WHERE LOWER(name) = LOWER(:name)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['name' => $name]);
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
     * Get tags with their associated products (limited number per tag)
     * Only returns tags that have at least one product
     * 
     * @param int $limitProductsPerTag Number of products to fetch per tag
     * @return array
     */
    public function getTagsWithProducts($limitProductsPerTag = 4)
    {
        // First get all tags that have at least one product
        $sql = "SELECT t.*, COUNT(pt.product_id) as product_count 
                FROM tags t 
                JOIN product_tags pt ON t.id = pt.tag_id 
                GROUP BY t.id, t.name, t.slug 
                HAVING COUNT(pt.product_id) > 0 
                ORDER BY t.name ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $tags = $stmt->fetchAll();
        
        // For each tag, get associated products
        foreach ($tags as &$tag) {
            $sql = "SELECT p.*, c.name as category_name, c.slug as category_slug 
                    FROM products p 
                    JOIN product_tags pt ON p.id = pt.product_id 
                    JOIN categories c ON p.category_id = c.id 
                    WHERE pt.tag_id = :tagId 
                    LIMIT :limit";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':tagId', $tag['id'], \PDO::PARAM_INT);
            $stmt->bindValue(':limit', $limitProductsPerTag, \PDO::PARAM_INT);
            $stmt->execute();
            $tag['products'] = $stmt->fetchAll();
        }
        
        return $tags;
    }
    
    /**
     * Get products by tag ID with pagination
     * 
     * @param int $tagId Tag ID
     * @param int $limit Number of products to retrieve
     * @param int $offset Offset for pagination
     * @return array
     */
    public function getProductsByTagId($tagId, $limit = null, $offset = 0)
    {
        $sql = "SELECT p.*, c.name as category_name, c.slug as category_slug 
                FROM products p 
                JOIN product_tags pt ON p.id = pt.product_id 
                JOIN categories c ON p.category_id = c.id 
                WHERE pt.tag_id = :tagId 
                ORDER BY p.created_at DESC";
        
        if ($limit !== null) {
            $sql .= " LIMIT :limit OFFSET :offset";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':tagId', (int)$tagId, \PDO::PARAM_INT);
            $stmt->bindValue(':limit', (int)$limit, \PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int)$offset, \PDO::PARAM_INT);
            $stmt->execute();
        } else {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':tagId', (int)$tagId, \PDO::PARAM_INT);
            $stmt->execute();
        }
        
        return $stmt->fetchAll();
    }
    
    /**
     * Get count of products by tag ID
     * 
     * @param int $tagId Tag ID
     * @return int
     */
    public function getProductCountByTagId($tagId)
    {
        $sql = "SELECT COUNT(*) as count 
                FROM products p 
                JOIN product_tags pt ON p.id = pt.product_id 
                WHERE pt.tag_id = :tagId";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['tagId' => $tagId]);
        $result = $stmt->fetch();
        return $result['count'];
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