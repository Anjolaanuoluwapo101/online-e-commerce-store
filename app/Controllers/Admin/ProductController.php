<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Services\R2Service;

class ProductController extends Controller
{
    private $categoryModel;
    private $productModel;
    private $r2Service;

    public function __construct()
    {
        parent::__construct();
        $this->categoryModel = new Category();
        $this->productModel = new Product();
        $this->r2Service = new R2Service();
    }

    /**
     * Show all products
     * 
     * @return void
     */
    public function index()
    {
        try {
            // Get all products
            $products = $this->productModel->getAll();
            
            // Get cart item count
            $cartItemCount = 0;
            if (isset($_SESSION['XCart'])) {
                $cartItemCount = count($_SESSION['XCart']);
            }
            
            $data = [
                'products' => $products,
                'cartItemCount' => $cartItemCount
            ];
            
            $this->view->renderWithLayout('admin/products/index', $data, 'layouts/admin');
        } catch (\Exception $e) {
            // Log the error
            error_log('Admin ProductController@index error: ' . $e->getMessage());
            
            // Get cart item count
            $cartItemCount = 0;
            if (isset($_SESSION['XCart'])) {
                $cartItemCount = count($_SESSION['XCart']);
            }
            
            // Render view with error message
            $data = [
                'products' => [],
                'cartItemCount' => $cartItemCount,
                'error' => 'An error occurred while loading products. Please try again later.'
            ];
            
            $this->view->renderWithLayout('admin/products/index', $data, 'layouts/admin');
        }
    }

    /**
     * Show form to add product
     * 
     * @return void
     */
    public function create()
    {
        try {
            $categories = $this->categoryModel->getAll();
            
            $data = [
                'categories' => $categories,
                'nameError' => '',
                'imageError' => '',
                'successMessage' => ''
            ];
            
            $this->view->renderWithLayout('admin/products/create', $data, 'layouts/admin');
        } catch (\Exception $e) {
            // Log the error
            error_log('Admin ProductController@create error: ' . $e->getMessage());
            
            // Get categories for the form
            $categories = $this->categoryModel->getAll();
            
            // Render view with error message
            $data = [
                'categories' => $categories,
                'nameError' => '',
                'imageError' => '',
                'successMessage' => '',
                'error' => 'An error occurred while loading the product creation form. Please try again later.'
            ];
            
            $this->view->renderWithLayout('admin/products/create', $data, 'layouts/admin');
        }
    }

    /**
     * Store new product
     * 
     * @return void
     */
    public function store()
    {
        $nameError = "";
        $imageError = "";
        $successMessage = "";
        
        try {
            if ($this->post('productname')) {
                // Initialize variables
                $name = htmlspecialchars(stripslashes(trim($this->post('productname'))));
                $brand = htmlspecialchars(trim($this->post('brand')));
                $quantity = intval($this->post('quantity'));
                $price = floatval($this->post('price'));
                $categoryId = intval($this->post('category_id'));
                $description = htmlspecialchars(trim($this->post('description')));

                // Store this values above as Old Values in Session
                $_SESSION['oldProductData'] = [
                    'name' => $name,
                    'brand' => $brand,
                    'quantity' => $quantity,
                    'price' => $price,
                    'categoryId' => $categoryId,
                    'description' => $description
                ];
                
                // Validate required fields
                if (empty($name)) {
                    $nameError = "<span style='color:red'> *Product name is required </span>";
                }
                
                if (empty($categoryId)) {
                    $nameError = "<span style='color:red'> *Category is required </span>";
                }
                
                if ($quantity < 0) {
                    $nameError = "<span style='color:red'> *Quantity must be zero or greater </span>";
                }
                
                if ($price <= 0) {
                    $nameError = "<span style='color:red'> *Price must be greater than zero </span>";
                }
                
                // Validate category if no other errors
                if (empty($nameError)) {
                    $category = $this->categoryModel->getById($categoryId);
                    if (!$category) {
                        $nameError = "<span style='color:red'> *Invalid category </span>";
                    }
                }
                
                // Check if product name already exists in this category
                if (empty($nameError)) {
                    $existingProduct = $this->productModel->getByNameAndCategory($name, $categoryId);
                    if ($existingProduct) {
                        $nameError = "<span style='color:red'> *Product Name already exists in this category </span>";
                    }
                }
                
                // Validate image if no other errors
                if (empty($nameError)) {
                    if (!isset($_FILES['image']) || $_FILES['image']['error'] === UPLOAD_ERR_NO_FILE) {
                        $imageError = "<span style='color:red'> *Product image is required </span>";
                    } elseif ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
                        $imageError = "<span style='color:red'> *Error uploading image </span>";
                    } elseif (!in_array($_FILES['image']['type'], ["image/jpeg", "image/png"])) {
                        $imageError = "<span style='color:red'> *Invalid file type. Only JPG and PNG images are allowed </span>";
                    } elseif ($_FILES['image']['size'] > 5000000) { // 5MB limit
                        $imageError = "<span style='color:red'> *Image file size too large. Maximum 5MB allowed </span>";
                    }
                }
                
                // Process if no errors
                if (empty($nameError) && empty($imageError)) {
                    // Process image using R2 service
                    $imageName = $_FILES['image']['name'];
                    // Sanitize name for filename (preserve spaces as underscores)
                    $sanitizedName = preg_replace('/[^a-zA-Z0-9-_ ]/', '', $name);
                    $sanitizedName = str_replace(' ', '_', $sanitizedName);
                    
                    // Determine file extension
                    $extension = "";
                    if ($_FILES['image']['type'] == "image/jpeg") {
                        $extension = ".jpg";
                    } elseif ($_FILES['image']['type'] == "image/png") {
                        $extension = ".png";
                    }
                    
                    $finalFileName = $sanitizedName . $extension;
                    $oldPath = $_FILES['image']['tmp_name'];
                    $mimeType = $_FILES['image']['type'];

                    // Upload to R2 instead of local storage
                    $imageUrl = $this->r2Service->uploadFile($oldPath, $finalFileName, $mimeType);

                    // Insert into database (use original name with spaces)
                    $data = [
                        'category_id' => $categoryId,
                        'productname' => $name, // Use original name with spaces
                        'brand' => $brand,
                        'price' => $price,
                        'quantity' => $quantity,
                        'imagepath' => $finalFileName, // Store just the filename, construct full URL when needed
                        'description' => $description,
                        'upvotes' => 0
                    ];
                    
                    $productId = $this->productModel->create($data);
                    if ($productId) {
                        $successMessage = "Product added successfully!";
                        // Clear old data from session on success
                        unset($_SESSION['oldProductData']);
                    } else {
                        $imageError = "<span style='color:red'> *Failed to save product to database </span>";
                    }
                }
            }
        } catch (\Exception $e) {
            // Log the error
            error_log('Admin ProductController@store error: ' . $e->getMessage());
            $imageError = "<span style='color:red'> *An unexpected error occurred. Please try again later. </span>";
        }
        
        $categories = $this->categoryModel->getAll();
        $data = [
            'categories' => $categories,
            'nameError' => $nameError,
            'imageError' => $imageError,
            'successMessage' => $successMessage
        ];
        
        $this->view->renderWithLayout('admin/products/create', $data, 'layouts/admin');
    }

    /**
     * Show form to edit product
     * 
     * @param int $id Product ID
     * @return void
     */
    public function edit($id)
    {
        try {
            $product = $this->productModel->getById($id);
            
            if (!$product) {
                http_response_code(404);
                echo "Product not found";
                return;
            }
            
            $categories = $this->categoryModel->getAll();
            
            $data = [
                'product' => $product,
                'categories' => $categories
            ];
            
            $this->view->renderWithLayout('admin/products/edit', $data, 'layouts/admin');
        } catch (\Exception $e) {
            // Log the error
            error_log('Admin ProductController@edit error: ' . $e->getMessage());
            
            // Get categories for the form
            $categories = $this->categoryModel->getAll();
            
            // Render view with error message
            $data = [
                'product' => null,
                'categories' => $categories,
                'error' => 'An error occurred while loading the product edit form. Please try again later.'
            ];
            
            $this->view->renderWithLayout('admin/products/edit', $data, 'layouts/admin');
        }
    }

    /**
     * Update product
     * 
     * @param int $id Product ID
     * @return void
     */
    public function update($id)
    {
        try {
            $product = $this->productModel->getById($id);
            
            if (!$product) {
                http_response_code(404);
                echo "Product not found";
                return;
            }
            
            // Get form data
            $data = [
                'productname' => htmlspecialchars(stripslashes(trim($this->post('productname')))),
                'brand' => htmlspecialchars(trim($this->post('brand'))),
                'price' => floatval($this->post('price')),
                'quantity' => intval($this->post('quantity')),
                'description' => htmlspecialchars(trim($this->post('description'))),
                'category_id' => intval($this->post('category_id'))
            ];
            
            // Update product
            if ($this->productModel->updateProduct($id, $data)) {
                $this->redirect("/admin/products/{$id}/edit");
            } else {
                echo "Error updating product";
            }
        } catch (\Exception $e) {
            // Log the error
            error_log('Admin ProductController@update error: ' . $e->getMessage());
            
            // Redirect with error message
            $_SESSION['errorMessage'] = 'An error occurred while updating the product. Please try again later.';
            $this->redirect("/admin/products/{$id}/edit");
        }
    }

    /**
     * Delete product
     * 
     * @param int $id Product ID
     * @return void
     */
    public function delete($id)
    {
        try {
            // First get the product to get the image filename
            $product = $this->productModel->getById($id);
            
            if (!$product) {
                http_response_code(404);
                echo "Product not found";
                return;
            }
            
            // Delete the image from R2 storage
            if (!empty($product['imagepath'])) {
                try {
                    $this->r2Service->deleteFile($product['imagepath']);
                } catch (\Exception $e) {
                    // Log the error but continue with product deletion
                    error_log("Failed to delete image from R2: " . $e->getMessage());
                }
            }
            
            // Delete the product from database
            if ($this->productModel->deleteProduct($id)) {
                $this->redirect('/admin/products');
            } else {
                echo "Error deleting product";
            }
        } catch (\Exception $e) {
            // Log the error
            error_log('Admin ProductController@delete error: ' . $e->getMessage());
            
            // Redirect with error message
            $_SESSION['errorMessage'] = 'An error occurred while deleting the product. Please try again later.';
            $this->redirect('/admin/products');
        }
    }
}