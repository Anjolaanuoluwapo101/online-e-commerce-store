<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\Order;
use App\Models\Payment;

class OrderController extends Controller
{
    private $orderModel;
    private $paymentModel;

    public function __construct()
    {
        parent::__construct();
        $this->orderModel = new Order();
        $this->paymentModel = new Payment();
    }

    /**
     * Display a listing of orders
     */
    public function index()
    {
        $orders = $this->orderModel->getAll();
        
        $this->view->renderWithLayout('admin/orders/index', [
            'orders' => $orders
        ], 'layouts/admin');
    }

    /**
     * Display the specified order
     */
    public function show($id)
    {
        $order = $this->orderModel->getById($id);
        
        if (!$order) {
            // Handle order not found
            http_response_code(404);
            echo "Order not found";
            return;
        }
        
        // Get associated payments
        $payments = $this->paymentModel->getByOrderId($id);
        
        $this->view->renderWithLayout('admin/orders/show', [
            'order' => $order,
            'payments' => $payments
        ], 'layouts/admin');
    }

    /**
     * Update order status
     */
    public function updateStatus($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $status = $_POST['status'] ?? '';
            $paymentStatus = $_POST['payment_status'] ?? '';
            
            // Validate status values
            $validStatuses = ['pending', 'processing', 'completed', 'cancelled'];
            $validPaymentStatuses = ['unpaid', 'paid', 'refunded'];
            
            if (in_array($status, $validStatuses)) {
                $this->orderModel->updateStatus($id, $status);
            }
            
            //Payment Status should be uneditable so I will comment this out
            // if (in_array($paymentStatus, $validPaymentStatuses)) {
            //     $this->orderModel->updatePaymentStatus($id, $paymentStatus);
            // } 
            
            // Redirect back to order details
            header("Location: /admin/orders/{$id}");
            exit;
        }
    }

    /**
     * Get orders with optional filtering and sorting (async)
     * 
     * @return void
     */
    public function filter()
    {
        try {
            $searchTerm = $this->get('search');
            $status = $this->get('status');
            $paymentStatus = $this->get('payment_status');
            $orderBy = $this->get('order_by', 'id');
            $direction = $this->get('direction', 'ASC');
            
            // For now, we'll return all orders since we don't have a complex filtering method in the model
            // In a production environment, you would implement proper filtering in the model
            $orders = $this->orderModel->getAll();
            
            // Apply client-side filtering for demonstration
            if ($searchTerm) {
                $filteredOrders = [];
                foreach ($orders as $order) {
                    if (stripos($order['email'], $searchTerm) !== false) {
                        $filteredOrders[] = $order;
                    }
                }
                $orders = $filteredOrders;
            }
            
            if ($status && $status !== 'all') {
                $filteredOrders = [];
                foreach ($orders as $order) {
                    if ($order['status'] === $status) {
                        $filteredOrders[] = $order;
                    }
                }
                $orders = $filteredOrders;
            }
            
            if ($paymentStatus && $paymentStatus !== 'all') {
                $filteredOrders = [];
                foreach ($orders as $order) {
                    if ($order['payment_status'] === $paymentStatus) {
                        $filteredOrders[] = $order;
                    }
                }
                $orders = $filteredOrders;
            }
            
            // Sort orders
            usort($orders, function($a, $b) use ($orderBy, $direction) {
                $result = 0;
                switch ($orderBy) {
                    case 'email':
                        $result = strcmp($a['email'], $b['email']);
                        break;
                    case 'total_amount':
                        $result = $a['total_amount'] <=> $b['total_amount'];
                        break;
                    case 'status':
                        $result = strcmp($a['status'], $b['status']);
                        break;
                    case 'payment_status':
                        $result = strcmp($a['payment_status'], $b['payment_status']);
                        break;
                    case 'created_at':
                    default:
                        $result = strcmp($a['created_at'], $b['created_at']);
                        break;
                }
                
                return $direction === 'DESC' ? -$result : $result;
            });
            
            header('Content-Type: application/json');
            echo json_encode($orders);
        } catch (\Exception $e) {
            // Log the error
            error_log('Admin\\OrderController@filter error: ' . $e->getMessage());
            // Return error response
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => 'An error occurred while filtering orders. Please try again later.']);
        }
    }
}