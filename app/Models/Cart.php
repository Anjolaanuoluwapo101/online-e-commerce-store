<?php

namespace App\Models;

class Cart
{
    private $sessionKey = 'XCart';

    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_name($this->sessionKey);
            session_start([
                "gc_maxlifetime" => 10000,
                "cookie_lifetime" => 10000
            ]);
        }
        
        if (!isset($_SESSION[$this->sessionKey])) {
            $_SESSION[$this->sessionKey] = [];
        }
    }

    /**
     * Add item to cart
     * 
     * @param array $item Item data
     * @return void
     */
    public function addItem($item)
    {
        $refId = $item['refId'];
        
        if (empty($_SESSION[$this->sessionKey])) {
            $_SESSION[$this->sessionKey][$refId] = $item;
        } elseif (!array_key_exists($refId, $_SESSION[$this->sessionKey])) {
            $_SESSION[$this->sessionKey][$refId] = $item;
        } else {
            $_SESSION[$this->sessionKey][$refId]['quantity'] = $item['quantity'];
        }
        
        session_write_close();
    }

    /**
     * Get all items in cart
     * 
     * @return array
     */
    public function getItems()
    {
        if(session_status() == PHP_SESSION_NONE){
            session_name($this->sessionKey);
            session_name($this->sessionKey);
            session_start();
        }
        $items = $_SESSION[$this->sessionKey] ?? [];
        session_write_close();
        return $items;
    }

    /**
     * Get item count in cart
     * 
     * @return int
     */
    public function getItemCount()
    {
        session_name($this->sessionKey);
        session_start();
        $count = count($_SESSION[$this->sessionKey] ?? []);
        session_write_close();
        return $count;
    }

    /**
     * Remove item from cart
     * 
     * @param string $refId Reference ID of item to remove
     * @return void
     */
    public function removeItem($refId)
    {
        // session_name($this->sessionKey);
        // session_start();
        unset($_SESSION[$this->sessionKey][$refId]);
        session_write_close();
    }

    /**
     * Clear cart
     * 
     * @return void
     */
    public function clear()
    {
        // session_name($this->sessionKey);
        // session_start();
        $_SESSION[$this->sessionKey] = [];
        session_write_close();
    }
}