<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Tag;
use App\Models\Category;

class TagController extends Controller
{
    private $tagModel;
    private $categoryModel;

    public function __construct()
    {
        parent::__construct();
        $this->tagModel = new Tag();
        $this->categoryModel = new Category();
    }

    /**
     * Show products by tag
     * 
     * @param string $tagSlug Tag slug
     * @return void
     */
    public function show($tagSlug)
    {
        try {
            // Get tag by slug
            $tag = $this->tagModel->getBySlug($tagSlug);
            if (!$tag) {
                http_response_code(404);
                echo "Tag not found";
                return;
            }
            
            // Pagination
            $page = $this->get('page', 1);
            $itemsPerPage = 10;
            $offset = ($page - 1) * $itemsPerPage;
            
            // Get products by tag
            $products = $this->tagModel->getProductsByTagId($tag['id'], $itemsPerPage, $offset);
            $totalCount = $this->tagModel->getProductCountByTagId($tag['id']);
            $totalPages = ceil($totalCount / $itemsPerPage);
            
            // Get all categories for filter
            $categories = $this->categoryModel->getAll();
            
            // Get cart item count
            $cartItemCount = 0;
            if (isset($_SESSION['XCart'])) {
                $cartItemCount = count($_SESSION['XCart']);
            }
            
            $data = [
                'tag' => $tag,
                'products' => $products,
                'currentPage' => $page,
                'totalPages' => $totalPages,
                'categories' => $categories,
                'cartItemCount' => $cartItemCount
            ];
            
            $this->view->renderWithLayout('tag/show', $data, 'layouts/main');
        } catch (\Exception $e) {
            // Log the error
            error_log('TagController@show error: ' . $e->getMessage());
            
            // Get all categories for filter
            $categories = $this->categoryModel->getAll();
            
            // Get cart item count
            $cartItemCount = 0;
            if (isset($_SESSION['XCart'])) {
                $cartItemCount = count($_SESSION['XCart']);
            }
            
            // Render view with error message
            $data = [
                'tag' => null,
                'products' => [],
                'currentPage' => 1,
                'totalPages' => 1,
                'categories' => $categories,
                'cartItemCount' => $cartItemCount,
                'error' => 'An error occurred while loading products. Please try again later.'
            ];
            
            $this->view->renderWithLayout('tag/show', $data, 'layouts/main');
        }
    }
}