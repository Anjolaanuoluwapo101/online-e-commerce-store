<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    private $productModel;
    private $categoryModel;

    public function __construct()
    {
        parent::__construct();
        $this->productModel = new Product();
        $this->categoryModel = new Category();
    }

    /**
     * Show all products
     * 
     * @param string $categorySlug Category slug (optional)
     * @return void
     */
    public function index($categorySlug = null)
    {
        try {
            $page = $this->get('page', 1);
            $itemsPerPage = 10;
            $offset = ($page - 1) * $itemsPerPage;
            
            $category = null;
            if ($categorySlug) {
                // Get category by slug
                $category = $this->categoryModel->getBySlug($categorySlug);
                if (!$category) {
                    http_response_code(404);
                    echo "Category not found";
                    return;
                }
                
                // Get products by category
                $products = $this->productModel->getByCategoryId($category['id'], $itemsPerPage, $offset);
                $totalCount = $this->productModel->getCountByCategory($category['id']);
            } else {
                // Get all products
                $products = $this->productModel->getAll($itemsPerPage, $offset);
                $totalCount = $this->productModel->getCount();
            }
            
            $totalPages = ceil($totalCount / $itemsPerPage);
            
            // Get all categories for filter
            $categories = $this->categoryModel->getAll();
            
            // Get cart item count
            $cartItemCount = 0;
            if (isset($_SESSION['XCart'])) {
                $cartItemCount = count($_SESSION['XCart']);
            }
            
            $data = [
                'products' => $products,
                'currentPage' => $page,
                'totalPages' => $totalPages,
                'category' => $category,
                'categories' => $categories,
                'cartItemCount' => $cartItemCount
            ];
            
            $this->view->renderWithLayout('products/index', $data, 'layouts/main');
        } catch (\Exception $e) {
            // Log the error
            error_log('ProductController@index error: ' . $e->getMessage());
            
            // Get all categories for filter
            $categories = $this->categoryModel->getAll();
            
            // Get cart item count
            $cartItemCount = 0;
            if (isset($_SESSION['XCart'])) {
                $cartItemCount = count($_SESSION['XCart']);
            }
            
            // Render view with error message
            $data = [
                'products' => [],
                'currentPage' => 1,
                'totalPages' => 1,
                'category' => null,
                'categories' => $categories,
                'cartItemCount' => $cartItemCount,
                'error' => 'An error occurred while loading products. Please try again later.'
            ];
            
            $this->view->renderWithLayout('products/index', $data, 'layouts/main');
        }
    }

    /**
     * Search products
     * 
     * @return void
     */
    public function search()
    {
        try {
            $search = $this->get('item');
            $page = $this->get('page', 1);
            $itemsPerPage = 3;
            $offset = ($page - 1) * $itemsPerPage;
            
            if ($search && $search !== 'all') {
                $products = $this->productModel->searchByName($search, $itemsPerPage, $offset);
                $totalCount = $this->productModel->getSearchCount($search);
            } else {
                $products = $this->productModel->getAll($itemsPerPage, $offset);
                $totalCount = $this->productModel->getCount();
            }
            
            $totalPages = ceil($totalCount / $itemsPerPage);
            
            // Get all categories for filter
            $categories = $this->categoryModel->getAll();
            
            // Get cart item count
            $cartItemCount = 0;
            if (isset($_SESSION['XCart'])) {
                $cartItemCount = count($_SESSION['XCart']);
            }
            
            $data = [
                'products' => $products,
                'currentPage' => $page,
                'totalPages' => $totalPages,
                'search' => $search,
                'categories' => $categories,
                'cartItemCount' => $cartItemCount
            ];
            
            $this->view->renderWithLayout('products/search', $data, 'layouts/main');
        } catch (\Exception $e) {
            // Log the error
            error_log('ProductController@search error: ' . $e->getMessage());
            
            // Get all categories for filter
            $categories = $this->categoryModel->getAll();
            
            // Get cart item count
            $cartItemCount = 0;
            if (isset($_SESSION['XCart'])) {
                $cartItemCount = count($_SESSION['XCart']);
            }
            
            // Render view with error message
            $data = [
                'products' => [],
                'currentPage' => 1,
                'totalPages' => 1,
                'search' => '',
                'categories' => $categories,
                'cartItemCount' => $cartItemCount,
                'error' => 'An error occurred while searching products. Please try again later.'
            ];
            
            $this->view->renderWithLayout('products/search', $data, 'layouts/main');
        }
    }

    /**
     * Show product details
     * 
     * @param string $categorySlug Category slug
     * @param string $productName Product name
     * @param int $id Product ID
     * @return void
     */
    public function show($categorySlug, $productName, $id)
    {
        try {
            $product = $this->productModel->getById($id);
            
            if (!$product || $product['category_slug'] !== $categorySlug) {
                http_response_code(404);
                echo "Product not found";
                return;
            }
            
            // Get all categories for navigation
            $categories = $this->categoryModel->getAll();
            
            // Get cart item count
            $cartItemCount = 0;
            if (isset($_SESSION['XCart'])) {
                $cartItemCount = count($_SESSION['XCart']);
            }
            
            $data = [
                'product' => $product,
                'categories' => $categories,
                'cartItemCount' => $cartItemCount
            ];
            
            $this->view->renderWithLayout('products/view', $data, 'layouts/main');
        } catch (\Exception $e) {
            // Log the error
            error_log('ProductController@show error: ' . $e->getMessage());
            
            // Get all categories for navigation
            $categories = $this->categoryModel->getAll();
            
            // Get cart item count
            $cartItemCount = 0;
            if (isset($_SESSION['XCart'])) {
                $cartItemCount = count($_SESSION['XCart']);
            }
            
            // Render view with error message
            $data = [
                'product' => null,
                'categories' => $categories,
                'cartItemCount' => $cartItemCount,
                'error' => 'An error occurred while loading the product. Please try again later.'
            ];
            
            $this->view->renderWithLayout('products/view', $data, 'layouts/main');
        }
    }
}