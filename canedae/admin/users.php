<?php
require_once __DIR__ . '/includes/admin_guard.php';
$page_title = 'Customers'; $admin_page = 'users';
$db = getDB();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
    $db->prepare("UPDATE users SET is_active = 1 - is_active WHERE id = ? AND role = 'user'")->execute([(int)$_POST['id']]);
    flash('Account updated.');
    redirect(BASE_URL . 'admin/users.php?q=' . urlencode($_POST['q'] ?? ''));
}
$q = trim($_GET['q'] ?? '');
$st = $db->prepare("SELECT u.*, (SELECT COUNT(*) FROM reservations r WHERE r.user_id = u.id) AS res_count
    FROM users u WHERE u.role = 'user' AND (CONCAT(u.first_name,' ',u.last_name) LIKE ? OR u.email LIKE ?) ORDER BY u.created_at DESC LIMIT 300");
$st->execute(["%$q%", "%$q%"]); $rows = $st->fetchAll();
include __DIR__ . '/includes/admin_header.php';
showFlash();
?>
<form method="GET" style="display:flex;gap:8px;max-width:480px"><input type="text" name="q" value="<?php echo e($q); ?>" placeholder="Search name or email" style="margin:0"><button class="btn">Search</button></form><br>
<div class="table-wrap"><?php if (!$rows): ?><div class="empty">No customers found.</div><?php else: ?><table>
  <tr><th>Name</th><th>Email</th><th>Phone</th><th>Joined</th><th>Reservations</th><th>Account</th><th></th></tr>
  <?php foreach ($rows as $u): ?>
  <tr><td><?php echo e($u['first_name'] . ' ' . $u['last_name']); ?></td><td><?php echo e($u['email']); ?></td><td><?php echo e($u['phone'] ?: '—'); ?></td>
    <td><?php echo e(date('M d, Y', strtotime($u['created_at']))); ?></td><td><?php echo (int)$u['res_count']; ?></td>
    <td><?php echo statusPill($u['is_active'] ? 'Active' : 'Disabled'); ?></td>
    <td><form method="POST" class="inline"><?php echo csrf_field(); ?><input type="hidden" name="id" value="<?php echo (int)$u['id']; ?>"><input type="hidden" name="q" value="<?php echo e($q); ?>">
      <button class="btn <?php echo $u['is_active'] ? 'btn-red' : 'btn-green'; ?>" onclick="return confirm('Change this account?')"><?php echo $u['is_active'] ? 'Disable' : 'Enable'; ?></button></form></td></tr>
  <?php endforeach; ?></table><?php endif; ?></div>
<?php include __DIR__ . '/includes/admin_footer.php'; ?>
