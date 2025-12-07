<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Services\PHPMailerService as Mailer;

class ContactController extends Controller
{

    protected $mailer;
    /**
     * Extend the constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->mailer = new Mailer();
    }


    /**
     * Show contact page
     * 
     * @return void
     */
    public function index()
    {
        try {
            // Get cart item count
            $cartItemCount = 0;
            if (isset($_SESSION['XCart'])) {
                $cartItemCount = count($_SESSION['XCart']);
            }
            
            $data = [
                'cartItemCount' => $cartItemCount
            ];
            
            $this->view->renderWithLayout('contact/index', $data, 'layouts/main');
        } catch (\Exception $e) {
            // Log the error
            error_log('ContactController@index error: ' . $e->getMessage());
            
            // Get cart item count
            $cartItemCount = 0;
            if (isset($_SESSION['XCart'])) {
                $cartItemCount = count($_SESSION['XCart']);
            }
            
            // Render view with error message
            $data = [
                'cartItemCount' => $cartItemCount,
                'error' => 'An error occurred while loading the contact page. Please try again later.'
            ];
            
            $this->view->renderWithLayout('contact/index', $data, 'layouts/main');
        }
    }

    /**
     * Handle contact form submission
     * 
     * @return void
     */
    public function submit()
    {
        try {
            // Check if it's an AJAX request
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                // Handle AJAX request
                $name = htmlspecialchars($_POST['name'] ?? '');
                $email = htmlspecialchars($_POST['email'] ?? '');
                $subject = htmlspecialchars($_POST['subject'] ?? '');
                $message = htmlspecialchars($_POST['message'] ?? '');
                
                // Validate input
                if (empty($name) || empty($email) || empty($subject) || empty($message)) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => 'All fields are required.']);
                    return;
                }
                
                // Validate email format
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => 'Please enter a valid email address.']);
                    return;
                }
                
                // Prepare email content
                $htmlBody = "
                    <h2>New Contact Form Submission</h2>
                    <p><strong>Name:</strong> {$name}</p>
                    <p><strong>Email:</strong> {$email}</p>
                    <p><strong>Subject:</strong> {$subject}</p>
                    <p><strong>Message:</strong></p>
                    <p>{$message}</p>
                ";
                
                // Send email
                if($this->mailer->sendEmail('info@shopconv.com', $subject, $htmlBody)){
                    header('Content-Type: application/json');
                    echo json_encode(['success' => true, 'message' => 'Thank you for contacting us. We will get back to you soon.']);
                } else {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => 'Sorry, there was an error sending your message. Please try again later.']);
                }
            } else {
                // Handle regular form submission (fallback)
                $name = htmlspecialchars($_POST['name'] ?? '');
                $email = htmlspecialchars($_POST['email'] ?? '');
                $subject = htmlspecialchars($_POST['subject'] ?? '');
                $message = htmlspecialchars($_POST['message'] ?? '');
                
                // Prepare email content
                $htmlBody = "
                    <h2>New Contact Form Submission</h2>
                    <p><strong>Name:</strong> {$name}</p>
                    <p><strong>Email:</strong> {$email}</p>
                    <p><strong>Subject:</strong> {$subject}</p>
                    <p><strong>Message:</strong></p>
                    <p>{$message}</p>
                ";
                
                if($this->mailer->sendEmail('info@shopconv.com', $subject, $htmlBody)){
                    $this->redirect('/contact?success=1');
                } else {
                    $this->redirect('/contact?error=1');
                }
            }
        } catch (\Exception $e) {
            // Log the error
            error_log('ContactController@submit error: ' . $e->getMessage());
            
            // Handle AJAX request
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                header('Content-Type: application/json');
                http_response_code(500);
                echo json_encode(['success' => false, 'message' => 'An error occurred while processing your request. Please try again later.']);
            } else {
                // For regular form submission, redirect with error
                $this->redirect('/contact?error=1');
            }
        }
    }
}