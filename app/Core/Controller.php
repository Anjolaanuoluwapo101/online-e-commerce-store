<?php

namespace App\Core;

class Controller
{
    protected $view;

    public function __construct()
    {
        $this->view = new View();
    }

    /**
     * Load a view file
     * 
     * @param string $view The view file name
     * @param array $data Data to pass to the view
     * @return void
     */
    protected function view($view, $data = [])
    {
        $this->view->render($view, $data);
    }

    /**
     * Redirect to a URL
     * 
     * @param string $url The URL to redirect to
     * @return void
     */
    protected function redirect($url)
    {
        header("Location: $url");
        exit();
    }

    /**
     * Get a value from $_POST
     * 
     * @param string $key The key to get
     * @param mixed $default The default value if key doesn't exist
     * @return mixed
     */
    protected function post($key, $default = null)
    {
        return $_POST[$key] ?? $default;
    }

    /**
     * Get a value from $_GET
     * 
     * @param string $key The key to get
     * @param mixed $default The default value if key doesn't exist
     * @return mixed
     */
    protected function get($key, $default = null)
    {
        return $_GET[$key] ?? $default;
    }

    /**
     * Get a value from $_SESSION
     * 
     * @param string $key The key to get
     * @param mixed $default The default value if key doesn't exist
     * @return mixed
     */
    protected function session($key, $default = null)
    {
        return $_SESSION[$key] ?? $default;
    }
}