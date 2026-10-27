<?php
require_once __DIR__ . '/includes/admin_guard.php';
$page_title = 'Calendar'; $admin_page = 'calendar';
$db = getDB();
$m = $_GET['m'] ?? ($_POST['m'] ?? date('Y-m'));
$first = preg_match('/^\d{4}-\d{2}$/', $m) ? DateTime::createFromFormat('Y-m-d', $m . '-01') : false;
if (!$first) { $first = new DateTime('first day of this month'); }
$m = $first->format('Y-m');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
    $act = $_POST['action'] ?? '';
    if ($act === 'block') {
        $d = trim($_POST['date'] ?? '');
        $dt = DateTime::createFromFormat('Y-m-d', $d);
        if (!$dt || $dt->format('Y-m-d') !== $d) flash('Choose a valid date.', true);
        else {
            $db->prepare("INSERT IGNORE INTO blocked_dates (blocked_date, reason) VALUES (?, ?)")->execute([$d, trim($_POST['reason'] ?? '')]);
            $c = $db->prepare("SELECT COUNT(*) FROM reservations WHERE event_date=? AND status IN ('Pending','Approved')"); $c->execute([$d]);
            flash('Date blocked.' . ($c->fetchColumn() > 0 ? ' Note: that date already has reservations, they are not affected.' : ''));
            $m = $dt->format('Y-m');
        }
    } elseif ($act === 'unblock') {
        $db->prepare("DELETE FROM blocked_dates WHERE id = ?")->execute([(int)$_POST['id']]); flash('Date unblocked.');
    }
    redirect(BASE_URL . 'admin/calendar.php?m=' . $m);
}

$start = $first->format('Y-m-01'); $end = $first->format('Y-m-t');
$b = $db->prepare("SELECT * FROM blocked_dates WHERE blocked_date BETWEEN ? AND ? ORDER BY blocked_date"); $b->execute([$start, $end]);
$blocked = []; foreach ($b->fetchAll() as $x) $blocked[$x['blocked_date']] = $x;
$bk = $db->prepare("SELECT event_date, COUNT(*) c, GROUP_CONCAT(COALESCE(NULLIF(event_name,''),'Event') SEPARATOR ', ') names
    FROM reservations WHERE event_date BETWEEN ? AND ? AND status <> 'Cancelled' GROUP BY event_date");
$bk->execute([$start, $end]);
$booked = []; foreach ($bk->fetchAll() as $x) $booked[$x['event_date']] = $x;

$prev = (clone $first)->modify('-1 month')->format('Y-m'); $next = (clone $first)->modify('+1 month')->format('Y-m');
$lead = (int)$first->format('w'); $days = (int)$first->format('t');
include __DIR__ . '/includes/admin_header.php';
showFlash();
?>
<p><a href="?m=<?php echo $prev; ?>">&larr; Previous</a> &nbsp; <strong><?php echo e($first->format('F Y')); ?></strong> &nbsp; <a href="?m=<?php echo $next; ?>">Next &rarr;</a></p>
<div class="cal">
  <?php foreach (['Sun','Mon','Tue','Wed','Thu','Fri','Sat'] as $h) echo "<div class=\"h\">$h</div>"; ?>
  <?php for ($i = 0; $i < $lead; $i++) echo '<div class="d off"></div>'; ?>
  <?php for ($d = 1; $d <= $days; $d++):
      $key = $first->format('Y-m-') . str_pad($d, 2, '0', STR_PAD_LEFT);
      $cnt = $booked[$key]['c'] ?? 0;
      $cls = isset($blocked[$key]) ? 'blk' : ($cnt >= 3 ? 'full' : ($cnt >= 1 ? 'lim' : '')); ?>
    <div class="d <?php echo $cls; ?>" title="<?php echo e($booked[$key]['names'] ?? ''); ?>">
      <b><?php echo $d; ?></b>
      <?php if (isset($blocked[$key])): ?>Blocked<?php echo $blocked[$key]['reason'] ? ': ' . e($blocked[$key]['reason']) : ''; ?><br><?php endif; ?>
      <?php if ($cnt): ?><?php echo (int)$cnt; ?> booking<?php echo $cnt > 1 ? 's' : ''; ?><?php echo $cnt >= 3 ? ' (full)' : ''; ?><?php endif; ?>
    </div>
  <?php endfor; ?>
</div>
<p style="color:var(--muted)">Yellow = limited (1–2 bookings). Red = blocked or full (3 bookings). Customers cannot pick red dates.</p>

<div class="grid2">
  <div class="panel"><h2>Block a date</h2>
    <form method="POST"><?php echo csrf_field(); ?><input type="hidden" name="m" value="<?php echo e($m); ?>"><input type="hidden" name="action" value="block">
      <label class="f">Date</label><input type="date" name="date" min="<?php echo date('Y-m-d'); ?>" required>
      <label class="f">Reason (optional)</label><input type="text" name="reason" placeholder="e.g. Holiday, owner away">
      <button class="btn btn-green">Block date</button></form></div>
  <div class="panel"><h2>Blocked this month</h2>
    <?php if (!$blocked): ?><div class="empty" style="padding:0">None.</div><?php endif; ?>
    <?php foreach ($blocked as $x): ?>
      <div class="kv"><span><?php echo e(date('M d, Y', strtotime($x['blocked_date']))); ?> <?php echo e($x['reason']); ?></span>
        <form method="POST" class="inline"><?php echo csrf_field(); ?><input type="hidden" name="m" value="<?php echo e($m); ?>"><input type="hidden" name="id" value="<?php echo (int)$x['id']; ?>">
          <button class="btn btn-red" name="action" value="unblock">Unblock</button></form></div>
    <?php endforeach; ?></div>
</div>
<?php include __DIR__ . '/includes/admin_footer.php'; ?>
