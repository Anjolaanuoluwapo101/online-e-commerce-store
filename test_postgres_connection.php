<?php
// Test PostgreSQL connection and basic operations
// require_once 'vendor/autoload.php';

// require Composer's autoloader
require __DIR__ . '/vendor/autoload.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

use App\Core\Database;
use App\Core\Migration;
use App\Models\Product;
use App\Models\Category;

echo "Testing PostgreSQL Connection and Operations\n";
echo "=============================================\n\n";

try {
    // Test database connection
    echo "1. Testing database connection...\n";
    $db = Database::getInstance()->getConnection();
    echo "✓ Database connection successful\n\n";
    
    // Test migration
    echo "2. Testing table creation...\n";
    $migration = new Migration();
    $migration->createTables();
    echo "✓ Tables created successfully\n\n";
    
    // Test basic CRUD operations
    echo "3. Testing basic CRUD operations...\n";
    
    // Test category creation
    $categoryModel = new Category();
    $categoryData = [
        'name' => 'Test Category ' . time(),
        'slug' => 'test-category-' . time(),
        'description' => 'Test category for PostgreSQL migration'
    ];
    
    $categoryModel->create($categoryData);
    echo "✓ Category created successfully\n";
    
    // Test category retrieval
    $categories = $categoryModel->getAll();
    echo "✓ Retrieved " . count($categories) . " categories\n";
    
    // Test product creation (if we have categories)
    if (!empty($categories)) {
        $firstCategory = $categories[0];
        $productModel = new Product();
        $productData = [
            'category_id' => $firstCategory['id'],
            'productname' => 'Test Product ' . time(),
            'brand' => 'Test Brand',
            'price' => 99.99,
            'quantity' => 10,
            'description' => 'Test product for PostgreSQL migration'
        ];
        
        $productModel->create($productData);
        echo "✓ Product created successfully\n";
        
        // Test product retrieval
        $products = $productModel->getAll(5);
        echo "✓ Retrieved " . count($products) . " products\n";
    }
    
    echo "\n✓ All PostgreSQL operations completed successfully!\n";
    
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}