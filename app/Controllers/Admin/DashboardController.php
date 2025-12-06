<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\ProductManager;
use App\Models\Category;

class DashboardController extends Controller
{
    private $productManager;
    private $category;
    

    public function __construct()
    {
        parent::__construct();
        $this->productManager = new ProductManager();
        $this->category = new Category();

    }

    /**
     * Show admin dashboard
     * 
     * @return void
     */
    public function index()
    {
        try {
            //Get total categories
            $totalCategories = $this->category->getTotalCategories();

            // Get total products
            $totalProducts = $this->productManager->getTotalCount();
            
            $data = [
                'totalProducts' => $totalProducts,
                'totalCategories' => $totalCategories
            ];
            
            $this->view->renderWithLayout('admin/dashboard/index', $data, 'layouts/admin');
        } catch (\Exception $e) {
            // Log the error
            error_log('Admin\\DashboardController@index error: ' . $e->getMessage());
            // Display a user-friendly error message
            http_response_code(500);
            echo 'An error occurred while loading the dashboard. Please try again later.';
        }
    }
}