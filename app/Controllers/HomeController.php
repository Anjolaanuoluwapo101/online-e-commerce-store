<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Product;

class HomeController extends Controller
{
    private $productModel;

    public function __construct()
    {
        parent::__construct();
        $this->productModel = new Product();
    }

    /**
     * Show homepage
     * 
     * @return void
     */
    public function index()
    {
        try {
            // Get hottest products
            $products = $this->productModel->getHottest(6);
            
            // Get cart item count
            $cartItemCount = 0;
            if (isset($_SESSION['XCart'])) {
                $cartItemCount = count($_SESSION['XCart']);
            }
            
            $data = [
                'products' => $products,
                'cartItemCount' => $cartItemCount
            ];
            
            $this->view->renderWithLayout('home/index', $data, 'layouts/main');
        } catch (\Exception $e) {
            // Log the error
            error_log('HomeController@index error: ' . $e->getMessage());
            // Display a user-friendly error message
            http_response_code(500);
            echo 'An error occurred while loading the page. Please try again later.';
        }
    }
}