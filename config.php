<?php
/**
 * Panna Heera Perfumery - Global Configuration
 */

if (defined('CONFIG_LOADED')) {
    return;
}
define('CONFIG_LOADED', true);

if (!defined('APP_INIT')) {
    define('APP_INIT', true);
}

// Brand & Company Information
if (!defined('SITE_NAME')) define('SITE_NAME', 'PANNA HEERA PERFUMERY');
if (!defined('BRAND_FIRST_NAME')) define('BRAND_FIRST_NAME', 'PANNA HEERA');
if (!defined('BRAND_LAST_NAME')) define('BRAND_LAST_NAME', 'PERFUMERY');
if (!defined('SITE_TAGLINE')) define('SITE_TAGLINE', 'Premium Glass Bottles, Designer Caps, Fine Mist Pumps & Fragrance Solutions');

// Contact & Social Details
if (!defined('PHONE_NUMBER')) define('PHONE_NUMBER', '+91 98765 43210');
if (!defined('PHONE_RAW')) define('PHONE_RAW', '+919876543210');
if (!defined('WHATSAPP_NUMBER')) define('WHATSAPP_NUMBER', '919876543210');
if (!defined('CONTACT_EMAIL')) define('CONTACT_EMAIL', 'sales@pannaheeraparfums.com');
if (!defined('COMPANY_ADDRESS')) define('COMPANY_ADDRESS', 'Industrial Fragrance Zone, Mumbai, Maharashtra 400001, India');
if (!defined('BUSINESS_HOURS')) define('BUSINESS_HOURS', 'Mon - Sat: 9:30 AM - 7:00 PM IST');

// Currency & Commerce
if (!defined('CURRENCY_SYMBOL')) define('CURRENCY_SYMBOL', '₹');
if (!defined('DEFAULT_TAX_RATE')) define('DEFAULT_TAX_RATE', 0.18); // 18% GST for B2B

/**
 * Helper to build instant WhatsApp chat link
 */
if (!function_exists('getWhatsAppLink')) {
    function getWhatsAppLink($customText = '') {
        $base = 'https://wa.me/' . WHATSAPP_NUMBER;
        if (!empty($customText)) {
            return $base . '?text=' . urlencode($customText);
        }
        return $base . '?text=' . urlencode('Hello Panna Heera Perfumery! I am interested in your perfume bottles and packaging solutions.');
    }
}

/**
 * Helper to format price
 */
if (!function_exists('formatPrice')) {
    function formatPrice($amount) {
        return CURRENCY_SYMBOL . ' ' . number_format($amount, 2);
    }
}

/**
 * Asset URL helper
 */
if (!function_exists('asset')) {
    function asset($path) {
        return ltrim($path, '/');
    }
}
