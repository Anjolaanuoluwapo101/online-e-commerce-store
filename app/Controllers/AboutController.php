<?php

namespace App\Controllers;

use App\Core\Controller;

class AboutController extends Controller
{
    /**
     * Show about page
     * 
     * @return void
     */
    public function index()
    {
        try {
            // Get cart item count
            $cartItemCount = 0;
            if (isset($_SESSION['XCart'])) {
                $cartItemCount = count($_SESSION['XCart']);
            }
            
            $data = [
                'cartItemCount' => $cartItemCount
            ];
            
            $this->view->renderWithLayout('about/index', $data, 'layouts/main');
        } catch (\Exception $e) {
            // Log the error
            error_log('AboutController@index error: ' . $e->getMessage());
            // Display a user-friendly error message
            http_response_code(500);
            echo 'An error occurred while loading the page. Please try again later.';
        }
    }
}