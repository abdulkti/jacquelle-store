<?php

use CodeIgniter\View\Table;
use Config\Services;

if (! function_exists('img_url')) {
    /**
     * Resolve an image path (relative or absolute) to a usable URL.
     *
     * Relative paths stored in the database (e.g. "assets/images/...")
     * are resolved against base_url so they work on nested routes like
     * /products/{id}/{slug}. Absolute URLs are returned unchanged.
     */
    function img_url($path)
    {
        if (empty($path)) {
            return '';
        }

        if (preg_match('#^(https?:)?//#i', $path) || str_starts_with($path, 'data:')) {
            return $path;
        }

        return base_url($path);
    }
}
