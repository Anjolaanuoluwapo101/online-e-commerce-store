<?php

namespace App\Models;

use App\Core\Model;

class ProductTag extends Model
{
    /**
     * Attach a tag to a product
     * 
     * @param int $productId Product ID
     * @param int $tagId Tag ID
     * @return bool
     */
    public function attachTag($productId, $tagId)
    {
        // Check if the relationship already exists
        if ($this->relationshipExists($productId, $tagId)) {
            return true; // Already exists, no need to insert
        }
        
        $data = [
            'product_id' => $productId,
            'tag_id' => $tagId
        ];
        
        return $this->insert('product_tags', $data);
    }

    /**
     * Detach a tag from a product
     * 
     * @param int $productId Product ID
     * @param int $tagId Tag ID
     * @return bool
     */
    public function detachTag($productId, $tagId)
    {
        $sql = "DELETE FROM product_tags WHERE product_id = :productId AND tag_id = :tagId";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'productId' => $productId,
            'tagId' => $tagId
        ]);
    }

    /**
     * Detach all tags from a product
     * 
     * @param int $productId Product ID
     * @return bool
     */
    public function detachAllTags($productId)
    {
        $sql = "DELETE FROM product_tags WHERE product_id = :productId";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['productId' => $productId]);
    }

    /**
     * Get all tags for a product
     * 
     * @param int $productId Product ID
     * @return array
     */
    public function getTagsForProduct($productId)
    {
        $sql = "SELECT t.* FROM tags t 
                JOIN product_tags pt ON t.id = pt.tag_id 
                WHERE pt.product_id = :productId";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['productId' => $productId]);
        return $stmt->fetchAll();
    }

    /**
     * Check if a product-tag relationship exists
     * 
     * @param int $productId Product ID
     * @param int $tagId Tag ID
     * @return bool
     */
    private function relationshipExists($productId, $tagId)
    {
        $sql = "SELECT COUNT(*) as count FROM product_tags 
                WHERE product_id = :productId AND tag_id = :tagId";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'productId' => $productId,
            'tagId' => $tagId
        ]);
        $result = $stmt->fetch();
        return $result['count'] > 0;
    }
}