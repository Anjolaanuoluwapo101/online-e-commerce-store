<?php

namespace App\Models;

use App\Core\Model;

class Order extends Model
{

    /*
     * Get all orders
     */
    public function getAll()
    {
        $sql = "SELECT * FROM orders ORDER BY id ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Get order by id
     */
    public function getById($id)
    {
        $sql = "SELECT * FROM orders WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Create a new order
     * 
     * @param string $email Customer email
     * @param float $totalAmount Total amount for the order
     * @param string $cartData Serialized cart data
     * @param string $address Customer delivery address
     * @return int|false Order ID or false on failure
     */
    public function create($email, $totalAmount, $cartData = null, $address = null)
    {
        // Using the createOrdersTable column structure in Migration.php
        $sql = "INSERT INTO orders(email, address, total_amount, cart_data) VALUES(:email, :address, :total_amount, :cart_data)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':email' => $email,
            ':address' => $address,
            ':total_amount' => $totalAmount,
            ':cart_data' => $cartData
        ]);
        if ($stmt) {
            // Get the id
            return $this->db->lastInsertId();
        } else {
            return false;
        }
    }

    /**
     * Update order status
     * 
     * @param int $orderId Order ID
     * @param string $status New status
     * @return bool Success status
     */
    public function updateStatus($orderId, $status)
    {
        $sql = "UPDATE orders SET status = :status WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':status' => $status,
            ':id' => $orderId
        ]);
    }

    /*
     * Update order payment status
     * 
     * @param int $orderId Order ID
     * @param string $paymentStatus New payment status
     * @return bool Success status
     */
    public function updatePaymentStatus($orderId, $paymentStatus)
    {
        $sql = "UPDATE orders SET payment_status = :payment_status WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':payment_status' => $paymentStatus,
            ':id' => $orderId
        ]);
    }
    
    /**
     * Update order with cart data
     * 
     * @param int $orderId Order ID
     * @param string $cartData Serialized cart data
     * @return bool Success status
     */
    public function updateCartData($orderId, $cartData)
    {
        $sql = "UPDATE orders SET cart_data = :cart_data WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':cart_data' => $cartData,
            ':id' => $orderId
        ]);
    }

    /*
     * Get payments by order ID
     */
    public function getPayments($orderId)
    {
        $paymentModel = new Payment();
        return $paymentModel->getByOrderId($orderId);
    }
}