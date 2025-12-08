<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Payment;
use App\Models\Order;
use App\Factory\PaymentGatewayFactory;
use App\Services\PHPMailerService as Mailer;


class PaymentController extends Controller
{
    private $orderModel;
    private $paymentModel;
    private $mailer;
    
    private $gatewayType;
    private $paymentGateway;

    private $callbackUrl; 


    public function __construct()
    {
        parent::__construct();
        $this->orderModel = new Order();
        $this->paymentModel = new Payment();
        $this->mailer = new Mailer();
        $this->callbackUrl = 'http://' . $_SERVER['HTTP_HOST'] . '/payment/callback';
                
        $this->gatewayType = 'Paystack'; // Default gateway type can be set here
        $this->paymentGateway = PaymentGatewayFactory::createGateway($this->gatewayType);
    }

    public function createTransaction()
    {
        try {
            // Validate email
            $email = $_POST['email'] ?? '';
            if (empty($email)) {
                throw new \Exception('Email is required.');
            }
            
            // Get address
            $address = $_POST['address'] ?? '';
            if (empty($address)) {
                throw new \Exception('Address is required.');
            }

            // Get cart items from session
            $cartItems = [];
            if (isset($_SESSION['XCart'])) {
                $cartItems = $_SESSION['XCart'];
            }

            // Validate cart is not empty
            if (empty($cartItems)) {
                throw new \Exception('Cart is empty.');
            }

            // Calculate total amount from cart items 
            $totalAmount = 0;
            foreach ($cartItems as $item) {
                $totalAmount += $item['price'] * $item['quantity'];
            }

            // Validate total amount
            if ($totalAmount <= 0) {
                throw new \Exception('Invalid cart total.');
            }

            // Serialize cart data for storage
            $cartData = json_encode($cartItems);

            // Generate reference number
            $reference = $this->generateReference();

            // Create the Order with calculated total and cart data
            $orderId = $this->orderModel->create($email, $totalAmount,  $cartData, $address);
            if (!$orderId) {
                throw new \Exception('Failed to create order.');
            }

            // Create the Payment
            $paymentId = $this->paymentModel->create($orderId, $totalAmount, $reference);

            if (!$paymentId) {
                throw new \Exception('Failed to create payment.');
            }

            // Create transaction with the calculated amount (convert to kobo for Paystack)
            $transaction = $this->paymentGateway->initializeTransaction(
                $email,
                $totalAmount,
                $reference,
                $this->callbackUrl
            );

            header('Location: ' . $transaction);
            exit();
        } catch (\Exception $e) {
            // Log the error
            error_log('PaymentController@createTransaction error: ' . $e->getMessage());
            
            // Redirect with error message
            $_SESSION['errorMessage'] = 'An error occurred while processing your payment. Please try again later.';
            $this->redirect('/cart');
        }
    }

    /* 
     * Callback function to handle payment confirmation from the gateway
     */
    public function verifyTransaction(){
        try{
            // Paystack sends reference as 'reference' parameter
            $referenceId = $_GET['reference'] ?? '';
            if(empty($referenceId)){
                throw new \Exception('Reference ID is missing.');
            }

            // Obtain the Payment Gateway Details
            $details = $this->paymentGateway->getTransactionDetails($referenceId);
            if(!$details){
                throw new \Exception('Payment details not found.');
            }

            // Get payment record by reference (reference is in payments table, not orders)
            $payment = $this->paymentModel->getByReference($referenceId);
            if(!$payment){
                throw new \Exception('Payment record not found.');
            }

            // Get the order details
            $order = $this->orderModel->getById($payment['order_id']);
            if(!$order){
                throw new \Exception('Order not found.');
            }

            // Obtain the Amount from the Order and compare with Payment Amount
            // Paystack returns amount in kobo, so we need to convert our stored amount
            $expectedAmount = $order['total_amount'] * 100; // Convert to kobo
            $actualAmount = $details->amount;
            
            if($expectedAmount != $actualAmount){
                $errorMessage = 'Payment amount mismatch. Amount paid is '.$actualAmount.' kobo but expected is '.$expectedAmount.' kobo';
                error_log($errorMessage);
                throw new \Exception($errorMessage);
            }

            // If successful, update both order and payment models
            $this->orderModel->updatePaymentStatus($order['id'], 'paid');
            $this->paymentModel->updateStatus($payment['id'], 'paid');

            // Send notification email to customer (invoice)
            $this->mailer->sendInvoice($order['email'], 'Order Confirmation #' . $order['id'], $order['cart_data'], $order['address'] ?? null);

            // Redirect to success page
            $this->redirect('/cart/success?order_id=' . $order['id']);
        }catch(\Exception $e){
            error_log('PaymentController@verifyTransaction error: ' . $e->getMessage());
            // Send an Email to admin or customer service about the error using the mailer service
            $this->mailer->sendMailToSiteOwner('Payment Verification Error', $e->getMessage());
            
            // Redirect to cart with error message
            $_SESSION['errorMessage'] = 'An error occurred during payment verification. Our team has been notified and will process your order manually.';
            $this->redirect('/cart');
        }
    }

    /* 
     * Cancel function to handle payment cancellation
     */
    public function cancelTransaction(){
        try{
            // Get reference from query parameter
            $referenceId = $_GET['reference'] ?? '';
            if(empty($referenceId)){
                throw new \Exception('Reference ID is missing.');
            }

            // Get payment record by reference
            $payment = $this->paymentModel->getByReference($referenceId);
            if(!$payment){
                throw new \Exception('Payment record not found.');
            }

            // Get the order details
            $order = $this->orderModel->getById($payment['order_id']);
            if(!$order){
                throw new \Exception('Order not found.');
            }

            // Update payment and order status to cancelled
            $this->paymentModel->updateStatus($payment['id'], 'unpaid');
            $this->orderModel->updateStatus($order['id'], 'cancelled');
            $this->orderModel->updatePaymentStatus($order['id'], 'unpaid');

            // Redirect to cart with cancellation message
            $_SESSION['successMessage'] = 'Payment was cancelled. Your order has been cancelled.';
            $this->redirect('/cart');
        }catch(\Exception $e){
            error_log('PaymentController@cancelTransaction error: ' . $e->getMessage());
            
            // Redirect to cart with error message
            $_SESSION['errorMessage'] = 'An error occurred during payment cancellation. Please contact support.';
            $this->redirect('/cart');
        }
    }

    /**
     * Show payment success page
     * 
     * @return void
     */
    public function success()
    {
        try {
            $orderId = $_GET['order_id'] ?? null;
            
            $data = [
                'orderId' => $orderId
            ];
            
            $this->view->renderWithLayout('cart/success', $data, 'layouts/main');
        } catch (\Exception $e) {
            // Log the error
            error_log('PaymentController@success error: ' . $e->getMessage());
            
            // Redirect to cart with error message
            $_SESSION['errorMessage'] = 'An error occurred while loading the success page. Please check your email for order confirmation.';
            $this->redirect('/cart');
        }
    }

    /**
     * Generates a unique, readable Reference ID
     * Example Output: ORD-202311-A7F2
     */
    private function generateReference($prefix = 'ORD'): string
    {
        $datePart = date('Ym');

        $randomPart = bin2hex(random_bytes(2)); // e.g., 'a7f2'

        // 3. Combine them
        return strtoupper($prefix . '-' . $datePart . '-' . $randomPart);
    }
}