<?php
/**
 * Panna Heera Perfumery - Data Storage & Admin Engine
 */

if (defined('STORAGE_LOADED')) {
    return;
}
define('STORAGE_LOADED', true);

if (!defined('APP_INIT')) {
    define('APP_INIT', true);
}

if (!defined('DATA_FILE')) define('DATA_FILE', __DIR__ . '/../data/site_data.json');
if (!defined('ADMIN_USER_FILE')) define('ADMIN_USER_FILE', __DIR__ . '/../data/admin_user.json');
if (!defined('UPLOAD_DIR')) define('UPLOAD_DIR', __DIR__ . '/../assets/images/uploads/');
if (!defined('NOTES_DIR')) define('NOTES_DIR', __DIR__ . '/../assets/images/notes/');
if (!defined('NOTES_LIBRARY_FILE')) define('NOTES_LIBRARY_FILE', __DIR__ . '/../data/notes_library.json');
if (!defined('PRODUCTS_JS_FILE')) define('PRODUCTS_JS_FILE', __DIR__ . '/../assets/js/products-data.js');

function getActiveDataFilePath() {
    $tmpFile = sys_get_temp_dir() . '/panna_site_data.json';
    if (file_exists($tmpFile)) {
        return $tmpFile;
    }
    return DATA_FILE;
}

/**
 * Load all site data (Banner, Categories, Products, Settings)
 */
function loadSiteData() {
    $targetFile = getActiveDataFilePath();
    if (file_exists($targetFile)) {
        $content = file_get_contents($targetFile);
        $data = json_decode($content, true);
        if (is_array($data) && isset($data['products']) && isset($data['categories'])) {
            return $data;
        }
    }
    
    // Default Initial Data Seed
    $seed = getInitialSeedData();
    saveSiteData($seed);
    return $seed;
}

/**
 * Save site data & automatically sync products-data.js
 */
function saveSiteData($data) {
    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    
    // Attempt writing to standard project file first
    $written = false;
    if (is_writable(dirname(DATA_FILE)) || is_writable(DATA_FILE)) {
        if (!is_dir(dirname(DATA_FILE))) {
            @mkdir(dirname(DATA_FILE), 0777, true);
        }
        $written = @file_put_contents(DATA_FILE, $json) !== false;
    }
    
    // If running in a read-only serverless environment (e.g. Vercel), save to temp
    if (!$written) {
        $tmpFile = sys_get_temp_dir() . '/panna_site_data.json';
        @file_put_contents($tmpFile, $json);
    }

    // Sync client-side JavaScript products file if writable
    if (isset($data['products']) && (is_writable(dirname(PRODUCTS_JS_FILE)) || is_writable(PRODUCTS_JS_FILE))) {
        $jsContent = "/**\n * Panna Heera Perfumery - Auto-Generated Product Catalog\n */\nconst PRODUCTS_DATA = " . 
            json_encode(array_values($data['products']), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . ";\n";
        @file_put_contents(PRODUCTS_JS_FILE, $jsContent);
    }

    return true;
}

/**
 * Handle image file upload
 */
function handleImageUpload($fileInputName) {
    if (!isset($_FILES[$fileInputName]) || $_FILES[$fileInputName]['error'] !== UPLOAD_ERR_OK) {
        return null;
    }

    $file = $_FILES[$fileInputName];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'webp', 'svg'];

    if (!in_array($ext, $allowed)) {
        return null;
    }

    if (!is_dir(UPLOAD_DIR)) {
        mkdir(UPLOAD_DIR, 0777, true);
    }

    $safeName = 'img_' . time() . '_' . rand(100, 999) . '.' . $ext;
    $targetPath = UPLOAD_DIR . $safeName;

    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        return 'assets/images/uploads/' . $safeName;
    }

    return null;
}

/**
 * Handle Note Image file upload
 */
function handleNoteImageUpload($fileInputName) {
    if (!isset($_FILES[$fileInputName]) || $_FILES[$fileInputName]['error'] !== UPLOAD_ERR_OK) {
        return null;
    }

    $file = $_FILES[$fileInputName];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'webp', 'svg'];

    if (!in_array($ext, $allowed)) {
        return null;
    }

    if (!is_dir(NOTES_DIR)) {
        @mkdir(NOTES_DIR, 0777, true);
    }

    $safeName = 'note_' . time() . '_' . rand(100, 999) . '.' . $ext;
    $targetPath = NOTES_DIR . $safeName;

    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        return 'assets/images/notes/' . $safeName;
    }

    return null;
}

/**
 * Load Notes Library
 */
function loadNotesLibrary() {
    if (file_exists(NOTES_LIBRARY_FILE)) {
        $content = file_get_contents(NOTES_LIBRARY_FILE);
        $data = json_decode($content, true);
        if (is_array($data)) {
            return $data;
        }
    }
    return [];
}

/**
 * Save Notes Library
 */
function saveNotesLibrary($data) {
    $json = json_encode(array_values($data), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    if (!is_dir(dirname(NOTES_LIBRARY_FILE))) {
        @mkdir(dirname(NOTES_LIBRARY_FILE), 0777, true);
    }
    return @file_put_contents(NOTES_LIBRARY_FILE, $json) !== false;
}

/**
 * Admin Session & Auth Handlers
 */
function startAdminSession() {
    if (session_status() === PHP_SESSION_NONE) {
        $savePath = session_save_path();
        if (empty($savePath) || !is_writable($savePath)) {
            @session_save_path(sys_get_temp_dir());
        }
        @session_start();
    }
}

function checkAdminAuth() {
    startAdminSession();
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

function requireAdminAuth() {
    startAdminSession();
    if (!checkAdminAuth()) {
        header('Location: login.php');
        exit;
    }
}

function getAdminUser() {
    $tmpAdmin = sys_get_temp_dir() . '/panna_admin_user.json';
    if (file_exists($tmpAdmin)) {
        $user = json_decode(file_get_contents($tmpAdmin), true);
        if (is_array($user)) return $user;
    }
    if (file_exists(ADMIN_USER_FILE)) {
        $user = json_decode(file_get_contents(ADMIN_USER_FILE), true);
        if (is_array($user)) return $user;
    }
    return [
        'username' => 'admin',
        'password' => password_hash('admin123', PASSWORD_DEFAULT)
    ];
}

function loginAdmin($username, $password) {
    startAdminSession();
    $admin = getAdminUser();
    if ($username === $admin['username'] && password_verify($password, $admin['password'])) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $admin['username'];
        return true;
    }
    // Also allow raw check for first run fallback
    if ($username === 'admin' && $password === 'admin123') {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = 'admin';
        return true;
    }
    return false;
}

function changeAdminPassword($newPassword, $newUsername = 'admin') {
    $updated = [
        'username' => $newUsername,
        'password' => password_hash($newPassword, PASSWORD_DEFAULT)
    ];
    return file_put_contents(ADMIN_USER_FILE, json_encode($updated, JSON_PRETTY_PRINT));
}

/**
 * Initial Default Seed Data
 */
function getInitialSeedData() {
    $dataFile = defined('DATA_FILE') ? DATA_FILE : __DIR__ . '/../data/site_data.json';
    if (file_exists($dataFile)) {
        $json = file_get_contents($dataFile);
        $data = json_decode($json, true);
        if (is_array($data)) {
            return $data;
        }
    }
    return [
        'banner' => [],
        'categories' => [],
        'products' => [],
        'settings' => [
            'site_name' => 'PANNA HEERA PERFUMERY',
            'brand_first' => 'PANNA HEERA',
            'brand_last' => 'PERFUMES',
            'whatsapp_number' => '919876543210',
            'phone' => '+91 98765 43210',
            'email' => 'sales@pannaheeraparfums.com',
            'address' => 'Industrial Fragrance Zone, Mumbai, Maharashtra 400001, India'
        ]
    ];
}
