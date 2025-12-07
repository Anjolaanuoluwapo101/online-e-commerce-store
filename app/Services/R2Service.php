<?php

namespace App\Services;

use Aws\S3\S3Client;
use Aws\Credentials\Credentials;
use Aws\Exception\AwsException;

class R2Service
{
    private $s3;
    private $bucketName;
    private $publicDomain;

    public function __construct()
    {
        // R2 Configuration (Storage, Using CloudFlare)
        // Try to get environment variables using $_SERVER first, then getenv()
        $accountId = $_SERVER['R2_ACCOUNT_ID'] ?? getenv('R2_ACCOUNT_ID');
        $accessKey = $_SERVER['R2_ACCESS_KEY_ID'] ?? getenv('R2_ACCESS_KEY_ID') ;
        $secretKey = $_SERVER['R2_SECRET_ACCESS_KEY'] ?? getenv('R2_SECRET_ACCESS_KEY');
        $this->bucketName = $_SERVER['R2_BUCKET_NAME'] ?? getenv('R2_BUCKET_NAME');
        $this->publicDomain = $_SERVER['R2_PUBLIC_BUCKET_URL'] ?? getenv('R2_PUBLIC_BUCKET_URL');

        // Check if any of the required values are missing
        if (empty($accountId) || empty($accessKey) || empty($secretKey)) {
            throw new \Exception("Missing R2 credentials. Please check your configuration.");
        }

        $credentials = new Credentials($accessKey, $secretKey);

        // Initialize client
        $this->s3 = new S3Client([
            'region' => 'auto', // R2 ignores region, but SDK requires it
            'version' => 'latest',
            'endpoint' => "https://$accountId.r2.cloudflarestorage.com",
            'credentials' => $credentials
        ]);
    }

    /**
     * Upload a file to R2
     */
    public function uploadFile($tempFilePath, $fileName, $mimeType)
    {
        try {
            // Prepend 'shopconv/' to the filename for organized storage
            $fullPath = 'shopconv/' . $fileName;
            
            // Upload the file
            $this->s3->putObject([
                'Bucket' => $this->bucketName,
                'Key'    => $fullPath,      
                'SourceFile' => $tempFilePath, 
                'ContentType' => $mimeType,
                // 'ACL' => 'public-read' // R2 doesn't always use ACLs same as AWS, relies on bucket settings
            ]);

            // Construct the public URL manually
            // R2 URLs are: PublicDomain + / + FileName
            return $this->publicDomain . '/' . $fullPath;

        } catch (AwsException $e) {
            // Log error locally
            error_log("R2 Upload Error: " . $e->getMessage());
            throw new \Exception("Failed to upload file to storage.");
        }
    }

    /**
     * Delete a file from R2
     */
    public function deleteFile($fileName)
    {
        try {
            // Prepend 'shopconv/' to the filename for organized storage
            $fullPath = 'shopconv/' . $fileName;
            
            $this->s3->deleteObject([
                'Bucket' => $this->bucketName,
                'Key'    => $fullPath
            ]);
            return true;
        } catch (AwsException $e) {
            error_log("R2 Delete Error: " . $e->getMessage());
            return false;
        }
    }
}