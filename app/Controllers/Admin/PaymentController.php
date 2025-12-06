<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\Payment;
use App\Models\Order;

class PaymentController extends Controller
{
    private $paymentModel;
    private $orderModel;

    public function __construct()
    {
        parent::__construct();
        $this->paymentModel = new Payment();
        $this->orderModel = new Order();
    }

    /**
     * Display a listing of payments
     */
    public function index()
    {
        $payments = $this->paymentModel->getAllWithOrderDetails();
        
        $this->view->renderWithLayout('admin/payments/index', [
            'payments' => $payments
        ], 'layouts/admin');
    }

    /**
     * Display the specified payment
     */
    public function show($id)
    {
        $payment = $this->paymentModel->getById($id);
        
        if (!$payment) {
            // Handle payment not found
            http_response_code(404);
            echo "Payment not found";
            return;
        }
        
        // Get associated order
        $order = $this->orderModel->getById($payment['order_id']);
        
        $this->view->renderWithLayout('admin/payments/show', [
            'payment' => $payment,
            'order' => $order
        ], 'layouts/admin');
    }

    /**
     * Update payment status
     */
    public function updateStatus($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $status = $_POST['status'] ?? '';
            
            // Validate status values
            $validStatuses = ['pending', 'success', 'failed'];
            
            if (in_array($status, $validStatuses)) {
                $this->paymentModel->updateStatus($id, $status);
            }
            
            // Redirect back to payment details
            header("Location: /admin/payments/{$id}");
            exit;
        }
    }

    /**
     * Get payments with optional filtering and sorting (async)
     * 
     * @return void
     */
    public function filter()
    {
        try {
            $searchTerm = $this->get('search');
            $status = $this->get('status');
            $orderBy = $this->get('order_by', 'id');
            $direction = $this->get('direction', 'ASC');
            
            // Get all payments with order details
            $payments = $this->paymentModel->getAllWithOrderDetails();
            
            // Apply client-side filtering for demonstration
            if ($searchTerm) {
                $filteredPayments = [];
                foreach ($payments as $payment) {
                    if (stripos($payment['order_email'], $searchTerm) !== false || 
                        stripos($payment['reference'], $searchTerm) !== false) {
                        $filteredPayments[] = $payment;
                    }
                }
                $payments = $filteredPayments;
            }
            
            if ($status && $status !== 'all') {
                $filteredPayments = [];
                foreach ($payments as $payment) {
                    if ($payment['status'] === $status) {
                        $filteredPayments[] = $payment;
                    }
                }
                $payments = $filteredPayments;
            }
            
            // Sort payments
            usort($payments, function($a, $b) use ($orderBy, $direction) {
                $result = 0;
                switch ($orderBy) {
                    case 'order_email':
                        $result = strcmp($a['order_email'], $b['order_email']);
                        break;
                    case 'reference':
                        $result = strcmp($a['reference'], $b['reference']);
                        break;
                    case 'amount':
                        $result = $a['amount'] <=> $b['amount'];
                        break;
                    case 'status':
                        $result = strcmp($a['status'], $b['status']);
                        break;
                    case 'channel':
                        $result = strcmp($a['channel'] ?? '', $b['channel'] ?? '');
                        break;
                    case 'created_at':
                    default:
                        $result = strcmp($a['created_at'], $b['created_at']);
                        break;
                }
                
                return $direction === 'DESC' ? -$result : $result;
            });
            
            header('Content-Type: application/json');
            echo json_encode($payments);
        } catch (\Exception $e) {
            // Log the error
            error_log('Admin\\PaymentController@filter error: ' . $e->getMessage());
            // Return error response
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => 'An error occurred while filtering payments. Please try again later.']);
        }
    }
}