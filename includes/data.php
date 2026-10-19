<?php
/**
 * Panna Heera Perfumery - Catalog & Category Data
 * Dynamically connected to storage.php JSON persistence
 */

if (!defined('APP_INIT')) {
    require_once __DIR__ . '/../config.php';
}

require_once __DIR__ . '/storage.php';

$siteData = loadSiteData();
$categories = $siteData['categories'] ?? [];
$products = $siteData['products'] ?? [];
$banner = $siteData['banner'] ?? [];

/**
 * Find product by ID
 */
if (!function_exists('getProductById')) {
    function getProductById($id) {
        global $products;
        foreach ($products as $product) {
            if ($product['id'] === $id) {
                return $product;
            }
        }
        return null;
    }
}

/**
 * Filter products by category
 */
if (!function_exists('getProductsByCategory')) {
    function getProductsByCategory($categoryId) {
        global $products;
        if (empty($categoryId) || $categoryId === 'all') {
            return $products;
        }
        return array_filter($products, function($p) use ($categoryId) {
            return $p['category'] === $categoryId;
        });
    }
}
