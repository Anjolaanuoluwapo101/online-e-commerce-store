<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Upvote;
use App\Models\Product;

class UpvoteController extends Controller
{
    private $upvote;
    private $productModel;

    public function __construct()
    {
        parent::__construct();
        $this->upvote = new Upvote();
        $this->productModel = new Product();
    }

    /**
     * Upvote a product
     * Called Asynchronous.
     * @param string $categorySlug Category slug
     * @param string $productName Product name
     * @param int $id Product ID
     * @return void
     */
    public function upvote($categorySlug, $productName, $id)
    {
        try {
            // Get product to verify it exists and belongs to the category
            $product = $this->productModel->getById($id);
            
            if (!$product || $product['category_slug'] !== $categorySlug) {
                echo "0"; // Product not found
                return;
            }
            
            $result = $this->upvote->upvote($id, $productName, $categorySlug);
            
            if ($result) {
                echo "1"; // Success
            } else {
                echo "0"; // Already upvoted
            }
        } catch (\Exception $e) {
            // Log the error
            error_log('UpvoteController@upvote error: ' . $e->getMessage());
            // Return error response
            echo "0"; // Error
        }
    }
}