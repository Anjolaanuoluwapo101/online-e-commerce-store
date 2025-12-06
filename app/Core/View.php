<?php

namespace App\Core;

class View
{
    /**
     * Render a view file
     * 
     * @param string $view The view file name
     * @param array $data Data to pass to the view
     * @return void
     */
    public function render($view, $data = [])
    {
        // Extract data to variables
        extract($data);

        // Determine view file path
        $viewFile = "../app/Views/" . $view . ".php";

        // Check if view file exists
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            throw new \Exception("View file not found: " . $viewFile);
        }
    }

    /**
     * Render a view file with layout
     * 
     * @param string $view The view file name
     * @param array $data Data to pass to the view
     * @param string $layout The layout file name
     * @return void
     */
    public function renderWithLayout($view, $data = [], $layout = 'layout')
    {
        // Extract data to variables
        extract($data);

        // Determine view file path
        $viewFile = "../app/Views/" . $view . ".php";
        $layoutFile = "../app/Views/" . $layout . ".php";

        // Check if view file exists
        if (!file_exists($viewFile)) {
            throw new \Exception("View file not found: " . $viewFile);
        }

        // Start output buffering to capture view content
        ob_start();
        require_once $viewFile;
        $viewContent = ob_get_clean();

        // Check if layout file exists
        if (file_exists($layoutFile)) {
            require_once $layoutFile;
        } else {
            // If no layout, just output the view content
            echo $viewContent;
        }
    }
}