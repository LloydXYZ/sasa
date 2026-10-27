<?php
require_once __DIR__ . '/includes/admin_guard.php';
$page_title = 'Reservations'; $admin_page = 'reservations';
$db = getDB();
$statuses = ['Pending','Approved','Completed','Cancelled'];
$status = $_GET['status'] ?? '';
if (!in_array($status, $statuses, true)) $status = '';
$q = trim($_GET['q'] ?? '');

$where = []; $p = [];
if ($status !== '') { $where[] = 'r.status = ?'; $p[] = $status; }
if ($q !== '') {
    $where[] = "(CONCAT(u.first_name,' ',u.last_name) LIKE ? OR r.event_name LIKE ? OR r.id = ?)";
    array_push($p, "%$q%", "%$q%", (int)$q);
}
$sql = "SELECT r.id, r.event_name, r.event_date, r.pax, r.total_amount, r.status, r.balance_paid,
               CONCAT(u.first_name,' ',u.last_name) AS customer, pk.name AS package_name
        FROM reservations r JOIN users u ON u.id = r.user_id
        LEFT JOIN packages pk ON pk.id = r.package_id"
     . ($where ? ' WHERE ' . implode(' AND ', $where) : '') . ' ORDER BY r.event_date DESC, r.id DESC LIMIT 200';
$st = $db->prepare($sql); $st->execute($p); $rows = $st->fetchAll();

include __DIR__ . '/includes/admin_header.php';
?>
<div class="tabs">
  <a href="reservations.php" class="<?php echo $status === '' ? 'on' : ''; ?>">All</a>
  <?php foreach ($statuses as $s): ?>
    <a href="?status=<?php echo $s; ?>" class="<?php echo $status === $s ? 'on' : ''; ?>"><?php echo $s; ?></a>
  <?php endforeach; ?>
</div>
<form method="GET" style="display:flex;gap:8px;max-width:520px">
  <input type="hidden" name="status" value="<?php echo e($status); ?>">
  <input type="text" name="q" value="<?php echo e($q); ?>" placeholder="Search customer, event name or ID" style="margin:0">
  <button class="btn">Search</button>
</form>
<br>
<div class="table-wrap">
<?php if (!$rows): ?><div class="empty">No reservations match.</div><?php else: ?>
<table>
  <tr><th>ID</th><th>Customer</th><th>Event</th><th>Package</th><th>Date</th><th>Guests</th><th>Total</th><th>Status</th><th></th></tr>
  <?php foreach ($rows as $r): ?>
  <tr>
    <td>#<?php echo (int)$r['id']; ?></td>
    <td><?php echo e($r['customer']); ?></td>
    <td><?php echo e($r['event_name'] ?: '—'); ?></td>
    <td><?php echo e($r['package_name'] ?: 'Trays only'); ?></td>
    <td><?php echo e(date('M d, Y', strtotime($r['event_date']))); ?></td>
    <td><?php echo (int)$r['pax']; ?></td>
    <td><?php echo e(formatPrice($r['total_amount'])); ?></td>
    <td><?php echo statusPill($r['status']); ?><?php echo $r['balance_paid'] ? ' <span class="pill pill-verified">Fully paid</span>' : ''; ?></td>
    <td><a href="reservation-view.php?id=<?php echo (int)$r['id']; ?>">Open</a></td>
  </tr>
  <?php endforeach; ?>
</table>
<?php endif; ?>
</div>
<?php include __DIR__ . '/includes/admin_footer.php'; ?>
