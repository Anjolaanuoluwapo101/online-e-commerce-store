<?php

namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;


class PHPMailerService
{
    private PHPMailer $mailer;

    public function __construct()
    {
        // Initialize PHPMailer with exceptions enabled
        $this->mailer = new PHPMailer(true);
        $this->configureSMTP();
    }

    /**
     * Sets up the SMTP configuration using environment variables.
     */
    private function configureSMTP(): void
    {
   
        $this->mailer->SMTPDebug = SMTP::DEBUG_OFF;

        $this->mailer->isSMTP();
        $this->mailer->Host       = $_SERVER['MAIL_SMTP_HOST'] ?? getenv('MAIL_SMTP_HOST');
        $this->mailer->SMTPAuth   = true;
        $this->mailer->Username   = $_SERVER['MAIL_SMTP_USERNAME'] ?? getenv('MAIL_SMTP_USERNAME');
        $this->mailer->Password   = $_SERVER['MAIL_SMTP_PASSWORD'] ?? getenv('MAIL_SMTP_PASSWORD');
        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
        $this->mailer->Port       = $_SERVER['MAIL_SMTP_PORT'] ?? getenv('MAIL_SMTP_PORT', 587);     // Default to 587

        // Set Default "From" address
        $this->mailer->setFrom(
            $_SERVER['FROM_EMAIL'] ?? getenv('FROM_EMAIL'),
            $_SERVER['FROM_NAME'] ?? getenv('FROM_NAME')
        );
    }
    
    /*
     * Send Mail to Site Owner
     */
    public function sendMailToSiteOwner(string $subject, string $message): bool
    {
        $siteOwnerEmail = $_SERVER['FROM_EMAIL'] ?? getenv('FROM_EMAIL');
        return $this->sendEmail($siteOwnerEmail, $subject, $message);
    }

    /**
     * The public method to send emails.
     * * @param string $toRecipient Email address of recipient
     * @param string $subject     Subject line
     * @param string $htmlBody    HTML content of the email
     * @param string $altBody     Plain text fallback
     * @return bool               True on success, False on failure
     */
    public function sendEmail(string $toRecipient, string $subject, string $htmlBody, string $altBody = ''): bool
    {
        try {
            // clear addresses from previous calls to ensure singleton safety
            $this->mailer->clearAddresses();
            $this->mailer->clearAttachments();

            $this->mailer->addAddress($toRecipient);
            $this->mailer->isHTML(true);
            $this->mailer->Subject = $subject;
            $this->mailer->Body    = $htmlBody;
            
            // Auto-generate AltBody if not provided
            $this->mailer->AltBody = $altBody ?: strip_tags($htmlBody);

            $this->mailer->send();
            return true;

        } catch (Exception $e) {
            // Log error internally if needed: error_log($this->mailer->ErrorInfo);
            echo $e->getMessage();
            error_log($e->getMessage());
            return false;
        }
    }

    /*
     * Send Formatted Cart Data as Invoice to User
     */
    public function sendInvoice(string $email, string $subject, string $cartData): bool
    {
        // Decode the cart data
        $items = json_decode($cartData, true);
        
        // If decoding failed, try to handle it as a serialized array
        if ($items === null && is_string($cartData)) {
            $items = unserialize($cartData);
        }
        
        // If still null, return false
        if ($items === null) {
            error_log("Failed to decode cart data for invoice");
            return false;
        }
        
        // Generate the invoice HTML
        $htmlBody = $this->generateInvoiceHtml($items, $email);
        
        // Send the email
        return $this->sendEmail($email, $subject, $htmlBody);
    }
    
    /**
     * Generate HTML for the invoice
     * 
     * @param array $items Cart items
     * @param string $customerEmail Customer email
     * @return string HTML content for the invoice
     */
    private function generateInvoiceHtml(array $items, string $customerEmail): string
    {
        // Calculate totals
        $subtotal = 0;
        foreach ($items as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        
        // For simplicity, we're not adding taxes or shipping in this example
        $total = $subtotal;
        
        // Generate HTML
        $html = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Your Invoice</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    line-height: 1.6;
                    color: #333;
                    max-width: 800px;
                    margin: 0 auto;
                    padding: 20px;
                }
                .header {
                    text-align: center;
                    border-bottom: 2px solid #eee;
                    padding-bottom: 20px;
                    margin-bottom: 30px;
                }
                .invoice-title {
                    color: #2c3e50;
                    margin-bottom: 10px;
                }
                .company-info {
                    text-align: left;
                    margin-bottom: 30px;
                }
                .customer-info {
                    text-align: right;
                    margin-bottom: 30px;
                }
                .items-table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-bottom: 30px;
                }
                .items-table th {
                    background-color:rgb(190, 27, 27);
                    color: white;
                    padding: 12px;
                    text-align: left;
                }
                .items-table td {
                    padding: 12px;
                    border-bottom: 1px solid #eee;
                }
                .items-table tr:nth-child(even) {
                    background-color: #f9f9f9;
                }
                .text-right {
                    text-align: right;
                }
                .totals {
                    width: 50%;
                    margin-left: auto;
                    margin-bottom: 30px;
                }
                .totals-row {
                    display: flex;
                    justify-content: space-between;
                    padding: 8px 0;
                }
                .totals-label {
                    font-weight: bold;
                }
                .total-amount {
                    font-size: 1.2em;
                    font-weight: bold;
                    color:rgb(190, 27, 27);
                }
                .footer {
                    text-align: center;
                    margin-top: 40px;
                    padding-top: 20px;
                    border-top: 1px solid #eee;
                    color: #7f8c8d;
                }
                .thank-you {
                    font-size: 1.3em;
                    color: #27ae60;
                    margin-bottom: 10px;
                }
            </style>
        </head>
        <body>
            <div class="header">
                <h1 class="invoice-title">INVOICE</h1>
                <p>Thank you for your purchase!</p>
            </div>
            
            <div class="company-info">
                <h2>ShopConvenient</h2>
                <p>123 Business Street<br>
                Commerce City, CC 12345<br>
                contact@shopconv.com</p>
            </div>
            
            <div class="customer-info">
                <h3>Bill To:</h3>
                <p>' . htmlspecialchars($customerEmail) . '</p>
            </div>
            
            <table class="items-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th class="text-right">Total</th>
                    </tr>
                </thead>
                <tbody>';
                
        foreach ($items as $item) {
            $itemTotal = $item['price'] * $item['quantity'];
            $html .= '
                    <tr>
                        <td>' . htmlspecialchars($item['productname']) . '</td>
                        <td>₦' . number_format($item['price'], 2) . '</td>
                        <td>' . $item['quantity'] . '</td>
                        <td class="text-right">$' . number_format($itemTotal, 2) . '</td>
                    </tr>';
        }
                
        $html .= '
                </tbody>
            </table>
            
            <div class="totals">
                <div class="totals-row">
                    <span class="totals-label">Subtotal:</span>
                    <span>$' . number_format($subtotal, 2) . '</span>
                </div>
                <div class="totals-row">
                    <span class="totals-label">Total:</span>
                    <span class="total-amount">₦' . number_format($total, 2) . '</span>
                </div>
            </div>
            
            <div class="footer">
                <p class="thank-you">Thank you for your business!</p>
                <p>If you have any questions about this invoice, please contact us at contact@shopconv.com</p>
                <p>&copy; ' . date('Y') . ' ShopConvenient. All rights reserved.</p>
            </div>
        </body>
        </html>';
        
        return $html;
    }
    
    /**
     * Expose the raw PHPMailer instance if you need 
     * to add attachments or custom headers externally.
     */
    public function getMailerInstance(): PHPMailer
    {
        return $this->mailer;
    }
}