<?php

// Load environment variables
// Check if on localhost 
// echo $_SERVER['HTTP_HOST'];
if (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false) {
    $dotenvPath = __DIR__ . '/../.env';
    if (file_exists($dotenvPath)) {
        $lines = file($dotenvPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            // Skip comments
            if (strpos($line, '#') === 0) {
                continue;
            }

            // Skip lines without equals sign
            if (strpos($line, '=') === false) {
                continue;
            }

            // Parse key-value pairs
            list($key, $value) = explode('=', $line, 2);

            // Remove quotes if present
            $value = trim($value);
            if (substr($value, 0, 1) === '"' && substr($value, -1) === '"') {
                $value = substr($value, 1, -1);
            } elseif (substr($value, 0, 1) === "'" && substr($value, -1) === "'") {
                $value = substr($value, 1, -1);
            }

            // Set environment variable
            $_SERVER[trim($key)] = $value;
            putenv(trim($key) . '=' . $value);
        }
    }
}

require_once '../vendor/autoload.php';
require_once '../app/Config/constants.php';

use App\Core\Router;

// Start session
session_name("XCart");
session_start();

// Create router instance
$router = new Router();

// Define routes
$router->get('/', 'HomeController', 'index');
$router->get('/about', 'AboutController', 'index');
$router->get('/contact', 'ContactController', 'index');
$router->post('/contact/submit', 'ContactController', 'submit');
$router->get('/products', 'ProductController', 'index');
$router->get('/products/{any}', 'ProductController', 'index');
$router->get('/products/{any}/{any}/{id}', 'ProductController', 'show');
$router->get('/products/search', 'ProductController', 'search');

$router->get('/cart', 'CartController', 'index');
$router->post('/cart/add', 'CartController', 'add');
$router->get('/cart/remove/{any}', 'CartController', 'remove');
$router->get('/cart/clear', 'CartController', 'clear');

$router->get('/upvote/{any}/{any}/{id}', 'UpvoteController', 'upvote');

// Payment routes
$router->post('/payment/create', 'PaymentController', 'createTransaction');
$router->get('/payment/callback', 'PaymentController', 'verifyTransaction');
$router->get('/payment/cancel', 'PaymentController', 'cancelTransaction');

// Admin routes
$router->get('/admin', 'Admin\DashboardController', 'index');

// Admin category routes
$router->get('/admin/categories', 'Admin\CategoryController', 'index');
$router->get('/admin/categories/create', 'Admin\CategoryController', 'create');
$router->post('/admin/categories/store', 'Admin\CategoryController', 'store');
$router->get('/admin/categories/{id}/edit', 'Admin\CategoryController', 'edit');
$router->post('/admin/categories/{id}/update', 'Admin\CategoryController', 'update');
$router->get('/admin/categories/{id}/delete', 'Admin\CategoryController', 'delete');
$router->get('/admin/categories/filter', 'Admin\CategoryController', 'filter');

// Admin tag routes
$router->get('/admin/tags', 'Admin\TagController', 'index');
$router->get('/admin/tags/create', 'Admin\TagController', 'create');
$router->post('/admin/tags/store', 'Admin\TagController', 'store');
$router->get('/admin/tags/{id}/edit', 'Admin\TagController', 'edit');
$router->post('/admin/tags/{id}/update', 'Admin\TagController', 'update');
$router->get('/admin/tags/{id}/delete', 'Admin\TagController', 'delete');

// Admin product routes
$router->get('/admin/products', 'Admin\ProductController', 'index');
$router->get('/admin/products/create', 'Admin\ProductController', 'create');
$router->post('/admin/products/store', 'Admin\ProductController', 'store');
$router->get('/admin/products/{id}/edit', 'Admin\ProductController', 'edit');
$router->post('/admin/products/{id}/update', 'Admin\ProductController', 'update');
$router->get('/admin/products/{id}/delete', 'Admin\ProductController', 'delete');
$router->get('/admin/products/filter', 'Admin\ProductController', 'filter');

// Admin order routes
$router->get('/admin/orders', 'Admin\OrderController', 'index');
$router->get('/admin/orders/{id}', 'Admin\OrderController', 'show');
$router->post('/admin/orders/{id}/update-status', 'Admin\OrderController', 'updateStatus');
$router->get('/admin/orders/filter', 'Admin\OrderController', 'filter');

// Admin payment routes
$router->get('/admin/payments', 'Admin\PaymentController', 'index');
$router->get('/admin/payments/{id}', 'Admin\PaymentController', 'show');
$router->post('/admin/payments/{id}/update-status', 'Admin\PaymentController', 'updateStatus');
$router->get('/admin/payments/filter', 'Admin\PaymentController', 'filter');

// Dispatch the request
$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];
$router->dispatch($uri, $method);