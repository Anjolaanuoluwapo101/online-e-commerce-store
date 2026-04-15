<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    private $categoryModel;

    public function __construct()
    {
        parent::__construct();
        $this->categoryModel = new Category();
    }

    /**
     * Show all categories
     * 
     * @return void
     */
    public function index()
    {
        try {
            $categories = $this->categoryModel->getAll();
            
            $data = [
                'categories' => $categories
            ];
            
            $this->view->renderWithLayout('admin/categories/index', $data, 'layouts/admin');
        } catch (\Exception $e) {
            // Log the error
            error_log('Admin\\CategoryController@index error: ' . $e->getMessage());
            
            // Render view with error message
            $data = [
                'categories' => [],
                'error' => 'An error occurred while loading categories. Please try again later.'
            ];
            
            $this->view->renderWithLayout('admin/categories/index', $data, 'layouts/admin');
        }
    }

    /**
     * Show form to create category
     * 
     * @return void
     */
    public function create()
    {
        try {
            $data = [
                'errors' => []
            ];
            
            $this->view->renderWithLayout('admin/categories/create', $data, 'layouts/admin');
        } catch (\Exception $e) {
            // Log the error
            error_log('Admin\\CategoryController@create error: ' . $e->getMessage());
            
            // Render view with error message
            $data = [
                'errors' => [],
                'error' => 'An error occurred while loading the create category form. Please try again later.'
            ];
            
            $this->view->renderWithLayout('admin/categories/create', $data, 'layouts/admin');
        }
    }

    /**
     * Store new category
     * 
     * @return void
     */
    public function store()
    {
        try {
            $errors = [];
            
            $name = trim($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');
            
            // Validation
            if (empty($name)) {
                $errors['name'] = 'Category name is required';
            }
            
            // Check if category already exists
            $existingCategory = $this->categoryModel->getBySlug($this->generateSlug($name));
            if ($existingCategory) {
                $errors['name'] = 'Category with this name already exists';
            }
            
            if (!empty($errors)) {
                $data = [
                    'errors' => $errors,
                    'name' => $name,
                    'description' => $description
                ];
                
                $this->view->renderWithLayout('admin/categories/create', $data, 'layouts/admin');
                return;
            }
            
            // Create category
            $data = [
                'name' => $name,
                'description' => $description
            ];
            
            if ($this->categoryModel->create($data)) {
                $this->redirect('/admin/categories');
            } else {
                $errors['general'] = 'Failed to create category';
                $data = [
                    'errors' => $errors,
                    'name' => $name,
                    'description' => $description
                ];
                
                $this->view->renderWithLayout('admin/categories/create', $data, 'layouts/admin');
            }
        } catch (\Exception $e) {
            // Log the error
            error_log('Admin\\CategoryController@store error: ' . $e->getMessage());
            
            // Redirect with error message
            $_SESSION['errorMessage'] = 'An error occurred while creating the category. Please try again later.';
            $this->redirect('/admin/categories');
        }
    }

    /**
     * Show form to edit category
     * 
     * @param int $id Category ID
     * @return void
     */
    public function edit($id)
    {
        try {
            $category = $this->categoryModel->getById($id);
            
            if (!$category) {
                http_response_code(404);
                echo "Category not found";
                return;
            }
            
            $data = [
                'category' => $category,
                'errors' => []
            ];
            
            $this->view->renderWithLayout('admin/categories/edit', $data, 'layouts/admin');
        } catch (\Exception $e) {
            // Log the error
            error_log('Admin\\CategoryController@edit error: ' . $e->getMessage());
            
            // Render view with error message
            $data = [
                'category' => null,
                'errors' => [],
                'error' => 'An error occurred while loading the edit category form. Please try again later.'
            ];
            
            $this->view->renderWithLayout('admin/categories/edit', $data, 'layouts/admin');
        }
    }

    /**
     * Update category
     * 
     * @param int $id Category ID
     * @return void
     */
    public function update($id)
    {
        try {
            $category = $this->categoryModel->getById($id);
            
            if (!$category) {
                http_response_code(404);
                echo "Category not found";
                return;
            }
            
            $errors = [];
            
            $name = trim($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');
            
            // Validation
            if (empty($name)) {
                $errors['name'] = 'Category name is required';
            }
            
            if (!empty($errors)) {
                $data = [
                    'category' => $category,
                    'errors' => $errors,
                    'name' => $name,
                    'description' => $description
                ];
                
                $this->view->renderWithLayout('admin/categories/edit', $data, 'layouts/admin');
                return;
            }
            
            // Update category
            $data = [
                'name' => $name,
                'description' => $description
            ];
            
            if ($this->categoryModel->updateCategory($id, $data)) {
                $this->redirect('/admin/categories');
            } else {
                $errors['general'] = 'Failed to update category';
                $data = [
                    'category' => $category,
                    'errors' => $errors,
                    'name' => $name,
                    'description' => $description
                ];
                
                $this->view->renderWithLayout('admin/categories/edit', $data, 'layouts/admin');
            }
        } catch (\Exception $e) {
            // Log the error
            error_log('Admin\\CategoryController@update error: ' . $e->getMessage());
            
            // Redirect with error message
            $_SESSION['errorMessage'] = 'An error occurred while updating the category. Please try again later.';
            $this->redirect('/admin/categories');
        }
    }

    /**
     * Delete category
     * 
     * @param int $id Category ID
     * @return void
     */
    public function delete($id)
    {
        try {
            $category = $this->categoryModel->getById($id);
            
            if (!$category) {
                http_response_code(404);
                echo "Category not found";
                return;
            }
            
            if ($this->categoryModel->deleteCategory($id)) {
                $this->redirect('/admin/categories');
            } else {
                throw new \Exception('Failed to delete category');
            }
        } catch (\Exception $e) {
            // Log the error
            error_log('Admin\\CategoryController@delete error: ' . $e->getMessage());
            
            // Redirect with error message
            $_SESSION['errorMessage'] = 'An error occurred while deleting the category. Please try again later.';
            $this->redirect('/admin/categories');
        }
    }

    /**
     * Get categories with optional filtering and sorting (async)
     * 
     * @return void
     */
    public function filter()
    {
        try {
            $searchTerm = $this->get('search');
            $orderBy = $this->get('order_by', 'id');
            $direction = $this->get('direction', 'ASC');
            
            if ($searchTerm) {
                $categories = $this->categoryModel->searchByName($searchTerm, $orderBy, $direction);
            } else {
                $categories = $this->categoryModel->getAll($orderBy, $direction);
            }
            
            header('Content-Type: application/json');
            echo json_encode($categories);
        } catch (\Exception $e) {
            // Log the error
            error_log('Admin\\CategoryController@filter error: ' . $e->getMessage());
            // Return error response
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(['error' => 'An error occurred while filtering categories. Please try again later.']);
        }
    }

    /**
     * Generate a URL-friendly slug from a string
     * 
     * @param string $text Input text
     * @return string
     */
    private function generateSlug($text)
    {
        // Replace non-letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        
        // Transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        
        // Remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);
        
        // Trim
        $text = trim($text, '-');
        
        // Remove duplicate -
        $text = preg_replace('~-+~', '-', $text);
        
        // Lowercase
        $text = strtolower($text);
        
        if (empty($text)) {
            return 'n-a';
        }
        
        return $text;
    }
}