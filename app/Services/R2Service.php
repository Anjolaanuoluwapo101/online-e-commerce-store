<?php

namespace App\Services;

class R2Service
{
    private $supabaseUrl;
    private $serviceRoleKey;
    private $bucketName;

    public function __construct()
    {
        // Supabase Storage Configuration
        // Try to get environment variables using $_SERVER first, then getenv()
        $this->supabaseUrl = $_SERVER['SUPABASE_URL'] ?? getenv('SUPABASE_URL');
        $this->serviceRoleKey = $_SERVER['SUPABASE_SERVICE_ROLE_KEY'] ?? getenv('SUPABASE_SERVICE_ROLE_KEY');
        $this->bucketName = $_SERVER['SUPABASE_STORAGE_BUCKET'] ?? getenv('SUPABASE_STORAGE_BUCKET');

        // Check if any of the required values are missing
        if (empty($this->supabaseUrl) || empty($this->serviceRoleKey) || empty($this->bucketName)) {
            throw new \Exception("Missing Supabase Storage credentials. Please check your configuration.");
        }
    }

    /**
     * Upload a file to Supabase Storage
     */
    public function uploadFile($tempFilePath, $fileName, $mimeType)
    {
        try {
            // Prepend 'shopconv/' to the filename for organized storage
            $fullPath = 'shopconv/' . $fileName;
            
            // Build the upload URL
            $uploadUrl = $this->supabaseUrl . '/storage/v1/object/' . $this->bucketName . '/' . $fullPath;
            
            // Read file contents
            $fileContents = file_get_contents($tempFilePath);
            if ($fileContents === false) {
                throw new \Exception("Failed to read file contents.");
            }
            
            // Initialize cURL
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $uploadUrl);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fileContents);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $this->serviceRoleKey,
                'Content-Type: ' . $mimeType,
                'Content-Length: ' . strlen($fileContents)
            ]);
            
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            curl_close($ch);
            
            if ($curlError) {
                throw new \Exception("cURL Error: " . $curlError);
            }
            
            if ($httpCode >= 200 && $httpCode < 300) {
                // Return the public URL
                return $this->supabaseUrl . '/storage/v1/object/public/' . $this->bucketName . '/' . $fullPath;
            } else {
                throw new \Exception("Upload failed with HTTP code: " . $httpCode . ", Response: " . $response);
            }

        } catch (\Exception $e) {
            // Log error locally
            error_log("Supabase Storage Upload Error: " . $e->getMessage());
            throw new \Exception("Failed to upload file to storage.");
        }
    }

    /**
     * Delete a file from Supabase Storage
     */
    public function deleteFile($fileName)
    {
        try {
            // Prepend 'shopconv/' to the filename for organized storage
            $fullPath = 'shopconv/' . $fileName;
            
            // Build the delete URL
            $deleteUrl = $this->supabaseUrl . '/storage/v1/object/' . $this->bucketName . '/' . $fullPath;
            
            // Initialize cURL
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $deleteUrl);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $this->serviceRoleKey
            ]);
            
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            curl_close($ch);
            
            if ($curlError) {
                error_log("Supabase Storage Delete cURL Error: " . $curlError);
                return false;
            }
            
            // Success codes: 200 OK or 204 No Content
            if ($httpCode >= 200 && $httpCode < 300) {
                return true;
            } else {
                error_log("Supabase Storage Delete Error - HTTP Code: " . $httpCode . ", Response: " . $response);
                return false;
            }
            
        } catch (\Exception $e) {
            error_log("Supabase Storage Delete Error: " . $e->getMessage());
            return false;
        }
    }
}