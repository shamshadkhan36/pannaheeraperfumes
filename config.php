<?php
/**
 * Panna Heera Perfumery - Global Configuration
 */

if (!defined('APP_INIT')) {
    define('APP_INIT', true);
}

// Brand & Company Information
define('SITE_NAME', 'PANNA HEERA PERFUMERY');
define('BRAND_FIRST_NAME', 'PANNA HEERA');
define('BRAND_LAST_NAME', 'PERFUMERY');
define('SITE_TAGLINE', 'Premium Glass Bottles, Designer Caps, Fine Mist Pumps & Fragrance Solutions');

// Contact & Social Details
define('PHONE_NUMBER', '+91 98765 43210');
define('PHONE_RAW', '+919876543210');
define('WHATSAPP_NUMBER', '919876543210');
define('CONTACT_EMAIL', 'sales@pannaheeraparfums.com');
define('COMPANY_ADDRESS', 'Industrial Fragrance Zone, Mumbai, Maharashtra 400001, India');
define('BUSINESS_HOURS', 'Mon - Sat: 9:30 AM - 7:00 PM IST');

// Currency & Commerce
define('CURRENCY_SYMBOL', '₹');
define('DEFAULT_TAX_RATE', 0.18); // 18% GST for B2B

/**
 * Helper to build instant WhatsApp chat link
 */
function getWhatsAppLink($customText = '') {
    $base = 'https://wa.me/' . WHATSAPP_NUMBER;
    if (!empty($customText)) {
        return $base . '?text=' . urlencode($customText);
    }
    return $base . '?text=' . urlencode('Hello Panna Heera Perfumery! I am interested in your perfume bottles and packaging solutions.');
}

/**
 * Helper to format price
 */
function formatPrice($amount) {
    return CURRENCY_SYMBOL . ' ' . number_format($amount, 2);
}

/**
 * Asset URL helper
 */
function asset($path) {
    return ltrim($path, '/');
}
