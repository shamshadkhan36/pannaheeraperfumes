<?php
/**
 * Panna Heera Perfumery - Admin Fragrance Notes API
 */
define('APP_INIT', true);
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/storage.php';

header('Content-Type: application/json; charset=UTF-8');

startAdminSession();
if (!checkAdminAuth()) {
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit;
}

$action = $_REQUEST['action'] ?? 'list';

if ($action === 'list') {
    $notes = loadNotesLibrary();
    echo json_encode(['success' => true, 'notes' => $notes]);
    exit;
}

if ($action === 'upload') {
    if (!isset($_FILES['note_image'])) {
        echo json_encode(['success' => false, 'error' => 'No image uploaded']);
        exit;
    }

    $uploaded = handleNoteImageUpload('note_image');
    if ($uploaded) {
        echo json_encode(['success' => true, 'url' => $uploaded]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to upload image. Supported formats: JPG, PNG, WEBP, SVG']);
    }
    exit;
}

if ($action === 'add_to_library') {
    $name = trim($_POST['name'] ?? '');
    $image = trim($_POST['image'] ?? '');
    $tier = trim($_POST['tier_default'] ?? 'top');

    if (empty($name)) {
        echo json_encode(['success' => false, 'error' => 'Note name is required']);
        exit;
    }

    // Check if new image was uploaded directly
    if (isset($_FILES['note_image']) && $_FILES['note_image']['error'] === UPLOAD_ERR_OK) {
        $uploaded = handleNoteImageUpload('note_image');
        if ($uploaded) {
            $image = $uploaded;
        }
    }

    if (empty($image)) {
        $image = 'assets/images/notes/patchouli.png'; // default fallback
    }

    $id = strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', $name));
    $library = loadNotesLibrary();

    // Check if already exists, update or add
    $found = false;
    foreach ($library as &$item) {
        if ($item['id'] === $id) {
            $item['name'] = $name;
            $item['image'] = $image;
            $item['tier_default'] = $tier;
            $found = true;
            break;
        }
    }
    if (!$found) {
        $library[] = [
            'id' => $id,
            'name' => $name,
            'tier_default' => $tier,
            'image' => $image
        ];
    }

    saveNotesLibrary($library);
    echo json_encode(['success' => true, 'note' => ['id' => $id, 'name' => $name, 'image' => $image, 'tier_default' => $tier]]);
    exit;
}

echo json_encode(['success' => false, 'error' => 'Invalid action']);
