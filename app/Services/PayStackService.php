<?php

namespace App\Services;

use Exception;


class PayStackService
{
    private string $secretKey;
    private string $baseUrl = 'https://api.paystack.co';

    public function __construct()
    {
        $this->secretKey = $_SERVER['PAYSTACK_SECRET_KEY'] ?? getenv('PAYSTACK_SECRET_KEY');

        if (!$this->secretKey) {
            throw new Exception("Paystack Secret Key is missing.");
        }
    }

    /**
     * Step 1: Initialize the transaction
     * Returns the Authorization URL to redirect the user to.
     */
    public function initializeTransaction(string $email, float $amount, string $reference, string $callbackUrl): ?string
    {
        $url = $this->baseUrl . '/transaction/initialize';

        $fields = [
            'email' => $email,
            'amount' => $amount * 100,
            'callback_url' => $callbackUrl,
            'reference' => $reference,
            'metadata' => [
                //add dynamic url
                'cancel_action' => $_SERVER['HTTP_HOST']."/payment/cancel" // Optional: where to go if they cancel
            ]
        ];

        $response = $this->makeRequest($url, 'POST', $fields);

        if ($response && $response->status) {
            return $response->data->authorization_url;
        }

        return null;
    }

    /**
     * Step 2: Verify the transaction
     * Call this on your callback page to confirm payment validity.
     */
    public function verifyTransaction(string $reference): bool
    {
        $details = $this->getTransactionDetails($reference);

        if (!$details) {
            return false;
        }

        // Check if transaction was successful
        if ($details->status === 'success' && $details->gateway_response === 'Successful') {
            return true;
        }

        return false;
    }

    /**
     * Calls Paystack to get the full details of a transaction.
     * @return object|null Returns the transaction data object or null on failure
     */
    public function getTransactionDetails(string $reference)
    {
        // The endpoint is GET /transaction/verify/{reference}
        $url = $this->baseUrl . "/transaction/verify/" . rawurlencode($reference);

        $response = $this->makeRequest($url, 'GET');

        if ($response && $response->status) {
            return $response->data; // Contains amount, status, metadata, etc.
        }

        return null;
    }

    /**
     * Internal cURL Helper
     */
    private function makeRequest(string $url, string $method, array $data = [])
    {
        $curl = curl_init();

        $headers = [
            "Authorization: Bearer " . $this->secretKey,
            "Cache-Control: no-cache",
            "Content-Type: application/json"
        ];

        $opts = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => $headers,
        ];

        if ($method === 'POST') {
            $opts[CURLOPT_POSTFIELDS] = json_encode($data);
        }

        curl_setopt_array($curl, $opts);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            // Log error: error_log("cURL Error: " . $err);
            return null;
        }

        return json_decode($response);
    }
}