<?php
require_once __DIR__ . '/includes/admin_guard.php';
$page_title = 'Payments'; $admin_page = 'payments';
$db = getDB();
$filter = $_GET['status'] ?? 'Pending';
if (!in_array($filter, ['Pending','Verified','Rejected'], true)) $filter = 'Pending';
$st = $db->prepare("SELECT pay.*, r.event_date, r.total_amount, CONCAT(u.first_name,' ',u.last_name) AS customer
    FROM payments pay JOIN reservations r ON r.id = pay.reservation_id JOIN users u ON u.id = r.user_id
    WHERE pay.status = ? ORDER BY pay.payment_date DESC LIMIT 200");
$st->execute([$filter]); $rows = $st->fetchAll();
include __DIR__ . '/includes/admin_header.php';
?>
<div class="tabs">
  <?php foreach (['Pending','Verified','Rejected'] as $s): ?>
    <a href="?status=<?php echo $s; ?>" class="<?php echo $filter === $s ? 'on' : ''; ?>"><?php echo $s; ?></a>
  <?php endforeach; ?>
</div>
<div class="table-wrap">
<?php if (!$rows): ?><div class="empty">No <?php echo e(strtolower($filter)); ?> payments.</div><?php else: ?>
<table>
  <tr><th>Reference</th><th>Customer</th><th>Reservation</th><th>Method</th><th>Amount</th><th>Submitted</th><th>Status</th><th></th></tr>
  <?php foreach ($rows as $p): ?>
  <tr>
    <td><?php echo e($p['reference_number']); ?></td>
    <td><?php echo e($p['customer']); ?></td>
    <td>#<?php echo (int)$p['reservation_id']; ?> · <?php echo e(date('M d, Y', strtotime($p['event_date']))); ?></td>
    <td><?php echo e($p['payment_method']); ?></td>
    <td><?php echo e(formatPrice($p['amount_paid'])); ?></td>
    <td><?php echo e(date('M d, g:i A', strtotime($p['payment_date']))); ?></td>
    <td><?php echo statusPill($p['status']); ?></td>
    <td><a href="reservation-view.php?id=<?php echo (int)$p['reservation_id']; ?>">Review</a></td>
  </tr>
  <?php endforeach; ?>
</table>
<?php endif; ?>
</div>
<?php include __DIR__ . '/includes/admin_footer.php'; ?>
