<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\Tag;

class TagController extends Controller
{
    private $tagModel;

    public function __construct()
    {
        parent::__construct();
        $this->tagModel = new Tag();
    }

    /**
     * Show all tags
     * 
     * @return void
     */
    public function index()
    {
        try {
            $tags = $this->tagModel->getAll();
            
            $data = [
                'tags' => $tags
            ];
            
            $this->view->renderWithLayout('admin/tags/index', $data, 'layouts/admin');
        } catch (\Exception $e) {
            // Log the error
            error_log('Admin\\TagController@index error: ' . $e->getMessage());
            
            // Render view with error message
            $data = [
                'tags' => [],
                'error' => 'An error occurred while loading tags. Please try again later.'
            ];
            
            $this->view->renderWithLayout('admin/tags/index', $data, 'layouts/admin');
        }
    }

    /**
     * Show form to create tag
     * 
     * @return void
     */
    public function create()
    {
        try {
            $data = [
                'errors' => []
            ];
            
            $this->view->renderWithLayout('admin/tags/create', $data, 'layouts/admin');
        } catch (\Exception $e) {
            // Log the error
            error_log('Admin\\TagController@create error: ' . $e->getMessage());
            
            // Render view with error message
            $data = [
                'errors' => [],
                'error' => 'An error occurred while loading the create tag form. Please try again later.'
            ];
            
            $this->view->renderWithLayout('admin/tags/create', $data, 'layouts/admin');
        }
    }

    /**
     * Store new tag
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
                $errors['name'] = 'Tag name is required';
            }
            
            // Check if tag already exists
            $existingTag = $this->tagModel->getBySlug($this->generateSlug($name));
            if ($existingTag) {
                $errors['name'] = 'Tag with this name already exists';
            }
            
            if (!empty($errors)) {
                $data = [
                    'errors' => $errors,
                    'name' => $name,
                    'description' => $description
                ];
                
                $this->view->renderWithLayout('admin/tags/create', $data, 'layouts/admin');
                return;
            }
            
            // Create tag
            $data = [
                'name' => $name,
                'description' => $description
            ];
            
            if ($this->tagModel->create($data)) {
                $this->redirect('/admin/tags');
            } else {
                $errors['general'] = 'Failed to create tag';
                $data = [
                    'errors' => $errors,
                    'name' => $name,
                    'description' => $description
                ];
                
                $this->view->renderWithLayout('admin/tags/create', $data, 'layouts/admin');
            }
        } catch (\Exception $e) {
            // Log the error
            error_log('Admin\\TagController@store error: ' . $e->getMessage());
            
            // Redirect with error message
            $_SESSION['errorMessage'] = 'An error occurred while creating the tag. Please try again later.';
            $this->redirect('/admin/tags');
        }
    }

    /**
     * Show form to edit tag
     * 
     * @param int $id Tag ID
     * @return void
     */
    public function edit($id)
    {
        try {
            $tag = $this->tagModel->getById($id);
            
            if (!$tag) {
                http_response_code(404);
                echo "Tag not found";
                return;
            }
            
            $data = [
                'tag' => $tag,
                'errors' => []
            ];
            
            $this->view->renderWithLayout('admin/tags/edit', $data, 'layouts/admin');
        } catch (\Exception $e) {
            // Log the error
            error_log('Admin\\TagController@edit error: ' . $e->getMessage());
            
            // Render view with error message
            $data = [
                'tag' => null,
                'errors' => [],
                'error' => 'An error occurred while loading the edit tag form. Please try again later.'
            ];
            
            $this->view->renderWithLayout('admin/tags/edit', $data, 'layouts/admin');
        }
    }

    /**
     * Update tag
     * 
     * @param int $id Tag ID
     * @return void
     */
    public function update($id)
    {
        try {
            $tag = $this->tagModel->getById($id);
            
            if (!$tag) {
                http_response_code(404);
                echo "Tag not found";
                return;
            }
            
            $errors = [];
            
            $name = trim($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');
            
            // Validation
            if (empty($name)) {
                $errors['name'] = 'Tag name is required';
            }
            
            if (!empty($errors)) {
                $data = [
                    'tag' => $tag,
                    'errors' => $errors,
                    'name' => $name,
                    'description' => $description
                ];
                
                $this->view->renderWithLayout('admin/tags/edit', $data, 'layouts/admin');
                return;
            }
            
            // Update tag
            $data = [
                'name' => $name,
                'description' => $description
            ];
            
            if ($this->tagModel->updateTag($id, $data)) {
                $this->redirect('/admin/tags');
            } else {
                $errors['general'] = 'Failed to update tag';
                $data = [
                    'tag' => $tag,
                    'errors' => $errors,
                    'name' => $name,
                    'description' => $description
                ];
                
                $this->view->renderWithLayout('admin/tags/edit', $data, 'layouts/admin');
            }
        } catch (\Exception $e) {
            // Log the error
            error_log('Admin\\TagController@update error: ' . $e->getMessage());
            
            // Redirect with error message
            $_SESSION['errorMessage'] = 'An error occurred while updating the tag. Please try again later.';
            $this->redirect('/admin/tags');
        }
    }

    /**
     * Delete tag
     * 
     * @param int $id Tag ID
     * @return void
     */
    public function delete($id)
    {
        try {
            $tag = $this->tagModel->getById($id);
            
            if (!$tag) {
                http_response_code(404);
                echo "Tag not found";
                return;
            }
            
            if ($this->tagModel->deleteTag($id)) {
                $this->redirect('/admin/tags');
            } else {
                throw new \Exception('Failed to delete tag');
            }
        } catch (\Exception $e) {
            // Log the error
            error_log('Admin\\TagController@delete error: ' . $e->getMessage());
            
            // Redirect with error message
            $_SESSION['errorMessage'] = 'An error occurred while deleting the tag. Please try again later.';
            $this->redirect('/admin/tags');
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