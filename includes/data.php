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
        global $products, $fragranceOils;
        if (!empty($products)) {
            foreach ($products as $product) {
                if ($product['id'] === $id) {
                    return $product;
                }
            }
        }
        if (!empty($fragranceOils)) {
            foreach ($fragranceOils as $oil) {
                if ($oil['id'] === $id || $oil['sno'] == $id) {
                    $p1k = '₹' . number_format($oil['price_1kg']);
                    $p100 = '₹' . number_format($oil['price_100gm']);
                    return [
                        'id' => $oil['id'],
                        'sno' => $oil['sno'],
                        'title' => $oil['full_name'],
                        'short_title' => $oil['fragrance_name'],
                        'brand' => $oil['brand'],
                        'category' => $oil['category_id'],
                        'category_title' => $oil['family'],
                        'image' => 'assets/images/categories/fragrance-oils.jpg',
                        'price' => $oil['price_100gm'],
                        'price_1kg' => $oil['price_1kg'],
                        'price_100gm' => $oil['price_100gm'],
                        'moq' => 100,
                        'moq_label' => '100 GM',
                        'capacity' => '100 GM - 1 KG',
                        'badge' => '100% Pure Oil',
                        'in_stock' => true,
                        'description' => "Ultra-concentrated pure fragrance oil inspired by {$oil['brand']} - {$oil['fragrance_name']}. 100% alcohol-free, long-lasting formulation suitable for fine perfumery, attar creation, and bespoke fragrance blending.",
                        'specs' => [
                            '100% pure undiluted perfume oil concentrate',
                            'Completely free from alcohol and volatile solvents',
                            'High longevity and diffusive sillage projection',
                            'Tested for skin-safety and IFRA benchmark compliance'
                        ],
                        'dimensions' => [
                            'Formulation' => 'Concentrated Fragrance Compound',
                            'Alcohol Content' => '0% (Alcohol-Free)',
                            '1 KG Bulk Pack' => $p1k,
                            '100 GM Pack' => $p100
                        ],
                        'options' => [
                            'Pack Size' => [
                                "1 KG Wholesale Flacon - {$p1k}",
                                "100 GM Production Lot - {$p100}"
                            ]
                        ]
                    ];
                }
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
            return array_values($products);
        }
        return array_values(array_filter($products, function($p) use ($categoryId) {
            return $p['category'] === $categoryId;
        }));
    }
}

/**
 * Load 1,040 Fragrance Oils
 */
if (!function_exists('getFragranceOils')) {
    function getFragranceOils() {
        $file = __DIR__ . '/../data/fragrance_oils.json';
        if (file_exists($file)) {
            $json = file_get_contents($file);
            $data = json_decode($json, true);
            if (is_array($data)) {
                return $data;
            }
        }
        return [];
    }
}
$fragranceOils = getFragranceOils();
