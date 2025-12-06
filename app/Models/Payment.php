<?php

namespace App\Models;

use App\Core\Model;

class Payment extends Model
{

    public function create($orderId, $amount, $reference)
    {
        $sql = "INSERT INTO payments (order_id, amount, reference) VALUES (:order_id, :amount, :reference)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':order_id' => $orderId,
            ':amount' => $amount,
            ':reference' => $reference
        ]);
        if ($stmt) {
            return $this->db->lastInsertId();
        } else {
            return false;
        }
    }

    /*
     * Update Status of Payment
     */
    public function updateStatus($paymentId, $status)
    {
        $sql = "UPDATE payments SET status = :status WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':id' => $paymentId,
            ':status' => $status
        ]);
        return true;
    }

    /*
     * Get Payment by Reference
     */
    public function getByReference($reference)
    {
        $sql = "SELECT * FROM payments WHERE reference = :reference";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['reference' => $reference]);
        return $stmt->fetch();
    }

    /*
     * Get Payment by ID
     */
    public function getById($id)
    {
        $sql = "SELECT * FROM payments WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    /*
     * Get all payments with order details
     */
    public function getAllWithOrderDetails()
    {
        $sql = "SELECT p.*, o.email as order_email, o.total_amount as order_total 
                FROM payments p 
                JOIN orders o ON p.order_id = o.id 
                ORDER BY p.created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /*
     * Get payments by order ID
     */
    public function getByOrderId($orderId)
    {
        $sql = "SELECT * FROM payments WHERE order_id = :order_id ORDER BY created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['order_id' => $orderId]);
        return $stmt->fetchAll();
    }
}