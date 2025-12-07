<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Cart;

class CartController extends Controller
{
    private $cart;

    public function __construct()
    {
        parent::__construct();
        $this->cart = new Cart();
    }

    /**
     * Show cart contents
     * 
     * @return void
     */
    public function index()
    {
        try {
            $items = $this->cart->getItems();
            $itemCount = $this->cart->getItemCount();
            
            // Calculate total
            $total = 0;
            foreach ($items as $item) {
                $total += $item['price'] * $item['quantity'];
            }
            
            $data = [
                'items' => $items,
                'itemCount' => $itemCount,
                'total' => $total
            ];
            
            $this->view->renderWithLayout('cart/index', $data, 'layouts/main');
        } catch (\Exception $e) {
            // Log the error
            error_log('CartController@index error: ' . $e->getMessage());
            
            // Render view with error message
            $data = [
                'items' => [],
                'itemCount' => 0,
                'total' => 0,
                'error' => 'An error occurred while loading the cart. Please try again later.'
            ];
            
            $this->view->renderWithLayout('cart/index', $data, 'layouts/main');
        }
    }

    /**
     * Add item to cart
     * 
     * @return void
     */
    public function add()
    {
        try {
            if ($this->post('id') && $this->post('productname')) {
                $item = [
                    'id' => $this->post('id'),
                    'productname' => urldecode($this->post('productname')),
                    'price' => $this->post('price'),
                    'refId' => $this->post('productname') . $this->post('id'),
                    'quantity' => round($this->post('quantity')),
                    'origin' => $this->post('origin')
                ];
                
                $this->cart->addItem($item);
            }
            
            // Redirect back to previous page
            $this->redirect($_SERVER['HTTP_REFERER'] ?? '/');
        } catch (\Exception $e) {
            // Log the error
            error_log('CartController@add error: ' . $e->getMessage());
            // Redirect with error message
            $this->redirect($_SERVER['HTTP_REFERER'] ?? '/' . '?cart_error=1');
        }
    }

    /**
     * Remove item from cart
     * 
     * @param string $refId Reference ID of item to remove
     * @return void
     */
    public function remove($refId)
    {
        try {
            $this->cart->removeItem($refId);
            $this->redirect('/cart');
        } catch (\Exception $e) {
            // Log the error
            error_log('CartController@remove error: ' . $e->getMessage());
            // Redirect with error message
            $this->redirect('/cart?cart_error=1');
        }
    }

    /**
     * Clear cart
     * 
     * @return void
     */
    public function clear()
    {
        try {
            $this->cart->clear();
            $this->redirect('/cart');
        } catch (\Exception $e) {
            // Log the error
            error_log('CartController@clear error: ' . $e->getMessage());
            // Redirect with error message
            $this->redirect('/cart?cart_error=1');
        }
    }
}