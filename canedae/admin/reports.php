<?php
require_once __DIR__ . '/includes/admin_guard.php';
$page_title = 'Reports'; $admin_page = 'reports';
$db = getDB();
$year = (int)($_GET['year'] ?? date('Y')); if ($year < 2000 || $year > 2100) $year = (int)date('Y');

$ev = array_fill(1, 12, ['c' => 0, 't' => 0]); $dp = array_fill(1, 12, 0); $bal = array_fill(1, 12, 0);
$s = $db->prepare("SELECT MONTH(event_date) m, COUNT(*) c, SUM(total_amount) t FROM reservations WHERE YEAR(event_date)=? AND status IN ('Approved','Completed') GROUP BY m");
$s->execute([$year]); foreach ($s->fetchAll() as $r) $ev[(int)$r['m']] = ['c' => (int)$r['c'], 't' => (float)$r['t']];
$s = $db->prepare("SELECT MONTH(payment_date) m, SUM(amount_paid) s FROM payments WHERE status='Verified' AND YEAR(payment_date)=? GROUP BY m");
$s->execute([$year]); foreach ($s->fetchAll() as $r) $dp[(int)$r['m']] = (float)$r['s'];
$s = $db->prepare("SELECT MONTH(r.balance_paid_at) m, SUM(GREATEST(r.total_amount - COALESCE((SELECT SUM(amount_paid) FROM payments WHERE reservation_id=r.id AND status='Verified'),0),0)) s
    FROM reservations r WHERE r.balance_paid=1 AND YEAR(r.balance_paid_at)=? GROUP BY m");
$s->execute([$year]); foreach ($s->fetchAll() as $r) $bal[(int)$r['m']] = (float)$r['s'];

$s = $db->prepare("SELECT status, COUNT(*) c FROM reservations WHERE YEAR(event_date)=? GROUP BY status"); $s->execute([$year]); $by_status = $s->fetchAll();
$s = $db->prepare("SELECT COALESCE(p.name,'Trays only') n, COUNT(*) c FROM reservations r LEFT JOIN packages p ON p.id=r.package_id
    WHERE YEAR(r.event_date)=? AND r.status IN ('Approved','Completed') GROUP BY n ORDER BY c DESC"); $s->execute([$year]); $by_pkg = $s->fetchAll();

include __DIR__ . '/includes/admin_header.php';
?>
<form method="GET" class="noprint" style="display:flex;gap:8px;max-width:260px"><input type="number" name="year" value="<?php echo $year; ?>" style="margin:0"><button class="btn">Show</button>
  <button type="button" class="btn btn-gold" onclick="window.print()">Print</button></form>
<h2>Monthly summary <?php echo $year; ?></h2>
<div class="table-wrap"><table>
  <tr><th>Month</th><th class="tr">Events</th><th class="tr">Booked value</th><th class="tr">Downpayments</th><th class="tr">Balances collected</th><th class="tr">Total collected</th></tr>
  <?php $T = ['c'=>0,'t'=>0,'d'=>0,'b'=>0];
  for ($i = 1; $i <= 12; $i++):
      $T['c'] += $ev[$i]['c']; $T['t'] += $ev[$i]['t']; $T['d'] += $dp[$i]; $T['b'] += $bal[$i]; ?>
    <tr><td><?php echo date('F', mktime(0, 0, 0, $i, 1)); ?></td><td class="tr"><?php echo $ev[$i]['c']; ?></td>
      <td class="tr"><?php echo e(formatPrice($ev[$i]['t'])); ?></td><td class="tr"><?php echo e(formatPrice($dp[$i])); ?></td>
      <td class="tr"><?php echo e(formatPrice($bal[$i])); ?></td><td class="tr"><?php echo e(formatPrice($dp[$i] + $bal[$i])); ?></td></tr>
  <?php endfor; ?>
  <tr class="tot"><td>Total</td><td class="tr"><?php echo $T['c']; ?></td><td class="tr"><?php echo e(formatPrice($T['t'])); ?></td>
    <td class="tr"><?php echo e(formatPrice($T['d'])); ?></td><td class="tr"><?php echo e(formatPrice($T['b'])); ?></td><td class="tr"><?php echo e(formatPrice($T['d'] + $T['b'])); ?></td></tr>
</table></div>
<p style="color:var(--muted)">Events and booked value count Approved and Completed reservations by event date. Collected amounts are by the date the payment was received or the balance was marked paid.</p>
<div class="grid2">
  <div class="panel"><h2>Reservations by status</h2><?php foreach ($by_status as $r): ?><div class="kv"><span><?php echo e($r['status']); ?></span><span><?php echo (int)$r['c']; ?></span></div><?php endforeach; ?><?php if (!$by_status) echo '<div class="empty" style="padding:0">No data.</div>'; ?></div>
  <div class="panel"><h2>Most booked packages</h2><?php foreach ($by_pkg as $r): ?><div class="kv"><span><?php echo e($r['n']); ?></span><span><?php echo (int)$r['c']; ?></span></div><?php endforeach; ?><?php if (!$by_pkg) echo '<div class="empty" style="padding:0">No data.</div>'; ?></div>
</div>
<?php include __DIR__ . '/includes/admin_footer.php'; ?>
