<?php
require_once __DIR__ . '/includes/admin_guard.php';
$page_title = 'Change password'; $admin_page = '';
$db = getDB();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
    $cur = $_POST['current'] ?? ''; $new = $_POST['new'] ?? ''; $conf = $_POST['confirm'] ?? '';
    $st = $db->prepare("SELECT password FROM users WHERE id = ?"); $st->execute([$_SESSION['user_id']]);
    $hash = $st->fetchColumn();
    if (!$hash || !password_verify($cur, $hash)) flash('Your current password is incorrect.', true);
    elseif (strlen($new) < 8) flash('The new password must be at least 8 characters.', true);
    elseif ($new !== $conf) flash('The new passwords do not match.', true);
    elseif ($new === $cur) flash('Choose a password different from the current one.', true);
    else {
        $db->prepare("UPDATE users SET password = ? WHERE id = ?")->execute([password_hash($new, PASSWORD_DEFAULT), $_SESSION['user_id']]);
        session_regenerate_id(true);
        flash('Password changed.');
    }
    redirect(BASE_URL . 'admin/change-password.php');
}
include __DIR__ . '/includes/admin_header.php';
showFlash();
?>
<div class="panel" style="max-width:460px">
  <form method="POST"><?php echo csrf_field(); ?>
    <label class="f">Current password</label><input type="password" name="current" required autocomplete="current-password">
    <label class="f">New password (8+ characters)</label><input type="password" name="new" required minlength="8" autocomplete="new-password">
    <label class="f">Confirm new password</label><input type="password" name="confirm" required minlength="8" autocomplete="new-password">
    <button class="btn btn-green">Change password</button>
  </form>
</div>
<?php include __DIR__ . '/includes/admin_footer.php'; ?>
