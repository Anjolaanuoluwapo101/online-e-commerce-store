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
    }

    /**
     * Show form to add product
     * 
     * @return void
     */
    public function create()
    {
        $categories = $this->categoryModel->getAll();
        
        $data = [
            'categories' => $categories,
            'nameError' => '',
            'imageError' => ''
        ];
        
        $this->view->renderWithLayout('admin/products/create', $data, 'layouts/admin');
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
        
        if ($this->post('productname')) {
            // Initialize variables
            $name = htmlspecialchars(stripslashes($this->post('productname')));
            $brand = htmlspecialchars($this->post('brand'));
            $quantity = htmlspecialchars($this->post('quantity'));
            $price = htmlspecialchars(stripslashes($this->post('price')));
            $categoryId = $this->post('category_id');
            $description = htmlspecialchars($this->post('description'));
            
            // Validate category
            $category = $this->categoryModel->getById($categoryId);
            if (!$category) {
                $nameError = "<span style='color:red'> *Invalid category </span>";
            }
            
            // Confirm image type
            if (empty($nameError) && ($_FILES['image']['type'] == "image/jpeg" || $_FILES['image']['type'] == "image/png")) {
                // Check if product name already exists in this category
                $existingProduct = $this->productModel->getByNameAndCategory($name, $categoryId);
                
                if ($existingProduct) {
                    $nameError = "<span style='color:red'> *Product Name already exists in this category </span>";
                } else {
                    // Process image using R2 service
                    try {
                        $imageName = $_FILES['image']['name'];
                        $invalid = [' ', '  ', '   '];
                        $name = str_replace($invalid, '', $name);
                        $fileName = $name;
                        
                        if ($_FILES['image']['type'] == "image/jpeg") {
                            $name = $name . ".jpg";
                        } else {
                            $name = $name . ".png";
                        }
                        
                        $oldPath = $_FILES['image']['tmp_name'];
                        $mimeType = $_FILES['image']['type'];
                        
                        // Upload to R2 instead of local storage
                        $imageUrl = $this->r2Service->uploadFile($oldPath, $name, $mimeType);

                        // Insert into database
                        $data = [
                            'category_id' => $categoryId,
                            'productname' => $fileName,
                            'brand' => $brand,
                            'price' => $price,
                            'quantity' => $quantity,
                            'imagepath' => $name, // Store just the filename, construct full URL when needed
                            'description' => $description,
                            'upvotes' => 0
                        ];
                        
                        if ($this->productModel->create($data)) {
                            echo "<script> alert('Product Added Successfully') </script>";
                        }
                    } catch (\Exception $e) {
                        $imageError = "<span style='color:red'>*Failed to upload image: " . $e->getMessage() . "</span>";
                    }
                }
            } else {
                $imageError = "<span style='color:red'>*Invalid File Type </span>";
            }
        }
        
        $categories = $this->categoryModel->getAll();
        $data = [
            'categories' => $categories,
            'nameError' => $nameError,
            'imageError' => $imageError
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
    }

    /**
     * Update product
     * 
     * @param int $id Product ID
     * @return void
     */
    public function update($id)
    {
        $product = $this->productModel->getById($id);
        
        if (!$product) {
            http_response_code(404);
            echo "Product not found";
            return;
        }
        
        // Get form data
        $data = [
            'productname' => htmlspecialchars(stripslashes($this->post('productname'))),
            'brand' => htmlspecialchars($this->post('brand')),
            'price' => htmlspecialchars(stripslashes($this->post('price'))),
            'quantity' => htmlspecialchars($this->post('quantity')),
            'description' => htmlspecialchars($this->post('description')),
            'category_id' => htmlspecialchars($this->post('category_id'))
        ];
        
        // Update product
        if ($this->productModel->updateProduct($id, $data)) {
            $this->redirect("/admin/products/{$id}/edit");
        } else {
            echo "Error updating product";
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
    }
}