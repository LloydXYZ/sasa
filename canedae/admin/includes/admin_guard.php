<?php
// admin/includes/admin_guard.php
// Include at the very top of every admin page.
require_once __DIR__ . '/../../config/db.php';
startSession();
requireLogin();   // not logged in -> auth/login.php
requireAdmin();   // logged in but not admin -> index.php

// ---- CSRF helpers (use on every form that changes data) ----
function csrf_token() {
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
    return $_SESSION['csrf'];
}
function csrf_field() {
    return '<input type="hidden" name="csrf" value="' . csrf_token() . '">';
}
function csrf_verify() {
    $ok = isset($_POST['csrf'], $_SESSION['csrf']) && hash_equals($_SESSION['csrf'], $_POST['csrf']);
    if (!$ok) { http_response_code(419); die('Invalid or expired form. Go back and try again.'); }
}

// ---- Output + display helpers ----
function e($v) { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
function statusPill($status) {
    return '<span class="pill pill-' . strtolower(preg_replace('/[^a-z]/i', '', $status)) . '">' . e($status) . '</span>';
}

// ---- Flash messages + image upload (used by the content pages) ----
function flash($msg, $err = false) { $_SESSION[$err ? 'admin_err' : 'admin_msg'] = $msg; }
function showFlash() {
    foreach (['admin_msg' => 'msg', 'admin_err' => 'msg err'] as $k => $cls) {
        if (!empty($_SESSION[$k])) { echo '<div class="' . $cls . '">' . e($_SESSION[$k]) . '</div>'; unset($_SESSION[$k]); }
    }
}
// Returns the saved relative path, or $old when no new file was chosen.
function saveImage($field, $old = null) {
    if (empty($_FILES[$field]) || $_FILES[$field]['error'] === UPLOAD_ERR_NO_FILE) return $old;
    $f = $_FILES[$field];
    if ($f['error'] !== UPLOAD_ERR_OK) throw new RuntimeException('Image upload failed.');
    $ext = strtolower(pathinfo($f['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, ['jpg','jpeg','png','webp'], true) || @getimagesize($f['tmp_name']) === false)
        throw new RuntimeException('Image must be a JPG, PNG or WEBP file.');
    if ($f['size'] > 3 * 1024 * 1024) throw new RuntimeException('Image must be 3 MB or smaller.');
    $dir = __DIR__ . '/../../assets/images/uploads/';
    if (!is_dir($dir)) mkdir($dir, 0755, true);
    $name = bin2hex(random_bytes(8)) . '.' . $ext;
    if (!move_uploaded_file($f['tmp_name'], $dir . $name)) throw new RuntimeException('Could not save the image.');
    return 'assets/images/uploads/' . $name;
}
