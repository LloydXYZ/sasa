<?php
// admin/dashboard.php  (login.php already redirects admins here)
require_once __DIR__ . '/includes/admin_guard.php';
$page_title = 'Dashboard';
$admin_page = 'dashboard';
$db = getDB();

$s = $db->query("SELECT
    (SELECT COUNT(*) FROM payments WHERE status = 'Pending') AS pending_pay,
    (SELECT COUNT(*) FROM reservations WHERE status IN ('Pending','Submitted')) AS pending_res,
    (SELECT COUNT(*) FROM reservations WHERE status = 'Approved' AND event_date >= CURDATE()) AS upcoming,
    (SELECT COALESCE(SUM(amount_paid),0) FROM payments WHERE status = 'Verified') AS income
")->fetch();

$recent = $db->query("SELECT r.id, r.event_name, r.event_date, r.pax, r.total_amount, r.status,
        CONCAT(u.first_name, ' ', u.last_name) AS customer
    FROM reservations r JOIN users u ON u.id = r.user_id
    ORDER BY r.created_at DESC LIMIT 8")->fetchAll();

include __DIR__ . '/includes/admin_header.php';
?>
<div class="stats">
  <div class="stat action">
    <div class="n"><?php echo (int)$s['pending_pay']; ?></div>
    <div class="l"><a href="payments.php">Payment proofs to verify</a></div>
  </div>
  <div class="stat"><div class="n"><?php echo (int)$s['pending_res']; ?></div><div class="l">Reservations awaiting confirmation</div></div>
  <div class="stat"><div class="n"><?php echo (int)$s['upcoming']; ?></div><div class="l">Upcoming confirmed events</div></div>
  <div class="stat"><div class="n"><?php echo e(formatPrice($s['income'])); ?></div><div class="l">Verified downpayments received</div></div>
</div>

<h2>Latest reservations</h2>
<div class="table-wrap">
<?php if (!$recent): ?>
  <div class="empty">No reservations yet. They will appear here once a customer completes a booking.</div>
<?php else: ?>
  <table>
    <tr><th>ID</th><th>Customer</th><th>Event</th><th>Date</th><th>Guests</th><th>Total</th><th>Status</th></tr>
    <?php foreach ($recent as $r): ?>
    <tr>
      <td><a href="reservation-view.php?id=<?php echo (int)$r["id"]; ?>">#<?php echo (int)$r["id"]; ?></a></td>
      <td><?php echo e($r['customer']); ?></td>
      <td><?php echo e($r['event_name'] ?: '—'); ?></td>
      <td><?php echo e(date('M d, Y', strtotime($r['event_date']))); ?></td>
      <td><?php echo (int)$r['pax']; ?></td>
      <td><?php echo e(formatPrice($r['total_amount'])); ?></td>
      <td><?php echo statusPill($r['status']); ?></td>
    </tr>
    <?php endforeach; ?>
  </table>
<?php endif; ?>
</div>
<?php include __DIR__ . '/includes/admin_footer.php'; ?>
