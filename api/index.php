<?php
/**
 * Panna Heera Perfumery - Vercel Serverless Gateway Router
 * Resolves all dynamic page requests and executes PHP scripts under Vercel runtime
 */

$projectRoot = dirname(__DIR__);
chdir($projectRoot);

// Ensure session directory is writable in serverless environments
if (session_status() === PHP_SESSION_NONE) {
    $currentSave = @session_save_path();
    if (empty($currentSave) || !@is_writable($currentSave)) {
        @session_save_path(sys_get_temp_dir());
    }
}

// Parse request URI path and query string
$requestUri = $_SERVER['REQUEST_URI'] ?? '/';
$urlParts = parse_url($requestUri);
$rawPath = trim($urlParts['path'] ?? '', '/');

// Preserve or re-populate $_GET from query string if necessary
if (!empty($urlParts['query'])) {
    parse_str($urlParts['query'], $parsedGet);
    $_GET = array_merge($parsedGet, $_GET);
}

// Route resolution
$target = 'index.php';

if ($rawPath === '' || $rawPath === 'index' || $rawPath === 'index.php') {
    $target = 'index.php';
} elseif (is_file($projectRoot . '/' . $rawPath)) {
    $target = $rawPath;
} elseif (is_file($projectRoot . '/' . $rawPath . '.php')) {
    $target = $rawPath . '.php';
} elseif (is_dir($projectRoot . '/' . $rawPath)) {
    if (is_file($projectRoot . '/' . $rawPath . '/index.php')) {
        $target = $rawPath . '/index.php';
    }
}

$targetFile = $projectRoot . '/' . $target;

if (is_file($targetFile)) {
    $ext = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Execute PHP scripts
    if ($ext === 'php') {
        $_SERVER['SCRIPT_FILENAME'] = $targetFile;
        $_SERVER['SCRIPT_NAME'] = '/' . $target;
        $_SERVER['PHP_SELF'] = '/' . $target;
        require $targetFile;
        exit;
    }

    // Static asset streaming fallback
    $mimeTypes = [
        'css'  => 'text/css',
        'js'   => 'application/javascript',
        'json' => 'application/json',
        'png'  => 'image/png',
        'jpg'  => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'webp' => 'image/webp',
        'svg'  => 'image/svg+xml',
        'gif'  => 'image/gif',
        'ico'  => 'image/x-icon',
        'woff' => 'font/woff',
        'woff2'=> 'font/woff2',
        'ttf'  => 'font/ttf'
    ];

    if (isset($mimeTypes[$ext])) {
        header('Content-Type: ' . $mimeTypes[$ext]);
    }
    header('Content-Length: ' . filesize($targetFile));
    readfile($targetFile);
    exit;
}

// Default fallback to index.php
$_SERVER['SCRIPT_FILENAME'] = $projectRoot . '/index.php';
$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['PHP_SELF'] = '/index.php';
require $projectRoot . '/index.php';
