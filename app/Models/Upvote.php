<?php

namespace App\Models;

use App\Core\Model;

class Upvote extends Model
{
    private $sessionKey = 'upvoteCookie';

    public function __construct()
    {
        parent::__construct();
        
        if (session_status() == PHP_SESSION_NONE) {
            ini_set("session.gc_maxlifetime", 60*60*24*7); // 7 days
            ini_set("session.cookie_lifetime", 60*60*24*7); // 7 days
            session_name($this->sessionKey);
            session_start();
        }
        
        if (!isset($_SESSION[$this->sessionKey])) {
            $_SESSION[$this->sessionKey] = [];
        }
    }

    /**
     * Check if user has upvoted a product
     * 
     * @param string $refId Reference ID of product
     * @return bool
     */
    public function hasUpvoted($refId)
    {
        return in_array($refId, $_SESSION[$this->sessionKey]);
    }

    /**
     * Upvote a product
     * 
     * @param int $id Product ID
     * @param string $productName Product name
     * @param string $category Product category
     * @return bool
     */
    public function upvote($id, $productName, $category)
    {
        $refId = $productName . $id;
        
        // Check if user has already upvoted this product
        if ($this->hasUpvoted($refId)) {
            return false;
        }

        // Update database
        $sql = "UPDATE `products` SET `upvotes` = upvotes + 1 WHERE `productname` = :productName AND `id` = :id";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([
            'productName' => $productName,
            'id' => $id
        ]);

        if ($result) {
            // Add to session
            $_SESSION[$this->sessionKey][] = $refId;
            session_write_close();
            return true;
        }

        return false;
    }
}