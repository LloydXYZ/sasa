<?php
require_once __DIR__ . '/includes/admin_guard.php';
$db = getDB();
$id = (int)($_GET['id'] ?? 0);

$st = $db->prepare("SELECT r.*, pk.name AS package_name, u.first_name, u.last_name, u.email, u.phone
    FROM reservations r JOIN users u ON u.id = r.user_id LEFT JOIN packages pk ON pk.id = r.package_id WHERE r.id = ?");
$st->execute([$id]); $r = $st->fetch();
if (!$r) { http_response_code(404); die('Reservation not found.'); }

// ---- Actions ----
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
    $action = $_POST['action'] ?? '';
    $note   = trim($_POST['note'] ?? '');
    $pay_id = (int)($_POST['payment_id'] ?? 0);
    $msg = ''; $err = '';

    if ($action === 'verify' || $action === 'reject') {
        $ps = $db->prepare("SELECT * FROM payments WHERE id = ? AND reservation_id = ?");
        $ps->execute([$pay_id, $id]); $pay = $ps->fetch();
        if (!$pay || $pay['status'] !== 'Pending') $err = 'That payment is not waiting for review.';
        elseif ($r['status'] !== 'Pending') $err = 'Only pending reservations can have payments reviewed.';
        elseif ($action === 'reject' && $note === '') $err = 'Add a reason so the customer knows what to fix.';
        elseif ($action === 'reject') {
            $db->prepare("UPDATE payments SET status='Rejected', admin_note=? WHERE id=?")->execute([$note, $pay_id]);
            $msg = 'Payment rejected. The customer can upload a new proof.';
        } else {
            $c = $db->prepare("SELECT COUNT(*) FROM reservations WHERE event_date = ? AND status = 'Approved' AND id <> ?");
            $c->execute([$r['event_date'], $id]);
            if ($c->fetchColumn() > 0 && empty($_POST['force'])) {
                $err = 'Another approved event is already on this date. Tick "Approve anyway" to continue.';
            } else {
                $db->beginTransaction();
                $db->prepare("UPDATE payments SET status='Verified', admin_note=NULL WHERE id=?")->execute([$pay_id]);
                $db->prepare("UPDATE reservations SET status='Approved' WHERE id=? AND status='Pending'")->execute([$id]);
                $db->commit();
                $msg = 'Payment verified. Reservation approved.';
            }
        }
    } elseif ($action === 'cancel') {
        if (!in_array($r['status'], ['Pending','Approved'], true)) $err = 'This reservation can no longer be cancelled.';
        elseif ($note === '') $err = 'Add a cancellation reason.';
        else {
            $db->prepare("UPDATE reservations SET status='Cancelled', admin_note=? WHERE id=?")->execute([$note, $id]);
            $msg = 'Reservation cancelled. The date is free again.';
        }
    } elseif ($action === 'complete') {
        if ($r['status'] !== 'Approved') $err = 'Only approved reservations can be completed.';
        else { $db->prepare("UPDATE reservations SET status='Completed' WHERE id=?")->execute([$id]); $msg = 'Marked as completed.'; }
    } elseif ($action === 'balance') {
        if (!in_array($r['status'], ['Approved','Completed'], true)) $err = 'Approve the reservation first.';
        else { $db->prepare("UPDATE reservations SET balance_paid=1, balance_paid_at=NOW() WHERE id=?")->execute([$id]); $msg = 'Remaining balance marked as paid.'; }
    }
    if ($msg) $_SESSION['admin_msg'] = $msg;
    if ($err) $_SESSION['admin_err'] = $err;
    redirect(BASE_URL . 'admin/reservation-view.php?id=' . $id);
}

// ---- Data for display ----
$pays = $db->prepare("SELECT * FROM payments WHERE reservation_id = ? ORDER BY id DESC");
$pays->execute([$id]); $pays = $pays->fetchAll();
$verified = 0.0; foreach ($pays as $p) if ($p['status'] === 'Verified') $verified += (float)$p['amount_paid'];
$balance = $r['balance_paid'] ? 0 : max(0, (float)$r['total_amount'] - $verified);

$menu = $db->prepare("SELECT mi.category, mi.item_name FROM reservation_menu rm JOIN menu_items mi ON mi.id = rm.menu_item_id
    WHERE rm.reservation_id = ? ORDER BY mi.category, mi.item_name");
$menu->execute([$id]); $menu_by_cat = [];
foreach ($menu->fetchAll() as $m) $menu_by_cat[$m['category']][] = $m['item_name'];

$trays = $db->prepare("SELECT t.name, t.price, rt.quantity FROM reservation_trays rt JOIN trays t ON t.id = rt.tray_id WHERE rt.reservation_id = ?");
$trays->execute([$id]); $trays = $trays->fetchAll();

$c = $db->prepare("SELECT COUNT(*) FROM reservations WHERE event_date = ? AND status = 'Approved' AND id <> ?");
$c->execute([$r['event_date'], $id]); $conflict = $c->fetchColumn() > 0;

$ok  = $_SESSION['admin_msg'] ?? '';  unset($_SESSION['admin_msg']);
$bad = $_SESSION['admin_err'] ?? '';  unset($_SESSION['admin_err']);

$page_title = 'Reservation #' . $id; $admin_page = 'reservations';
include __DIR__ . '/includes/admin_header.php';
?>
<?php if ($ok): ?><div class="msg"><?php echo e($ok); ?></div><?php endif; ?>
<?php if ($bad): ?><div class="msg err"><?php echo e($bad); ?></div><?php endif; ?>
<p><a href="reservations.php">&larr; All reservations</a> &nbsp; <?php echo statusPill($r['status']); ?>
   <?php echo $r['balance_paid'] ? '<span class="pill pill-verified">Fully paid</span>' : ''; ?></p>

<div class="grid2">
  <div class="panel">
    <h2>Event</h2>
    <div class="kv"><span>Event</span><span><?php echo e($r['event_name'] ?: '—'); ?> <?php echo $r['event_type'] ? '(' . e($r['event_type']) . ')' : ''; ?></span></div>
    <div class="kv"><span>Date &amp; time</span><span><?php echo e(date('F j, Y', strtotime($r['event_date'])) . ', ' . date('g:i A', strtotime($r['event_time']))); ?></span></div>
    <div class="kv"><span>Venue</span><span><?php echo e($r['event_venue']); ?></span></div>
    <div class="kv"><span>Guests</span><span><?php echo (int)$r['pax']; ?></span></div>
    <div class="kv"><span>Special requests</span><span><?php echo e($r['special_requests'] ?: '—'); ?></span></div>
    <?php if ($r['admin_note']): ?><div class="kv"><span>Admin note</span><span><?php echo e($r['admin_note']); ?></span></div><?php endif; ?>
  </div>
  <div class="panel">
    <h2>Customer</h2>
    <div class="kv"><span>Name</span><span><?php echo e($r['first_name'] . ' ' . $r['last_name']); ?></span></div>
    <div class="kv"><span>Email</span><span><?php echo e($r['email']); ?></span></div>
    <div class="kv"><span>Phone</span><span><?php echo e($r['phone'] ?: '—'); ?></span></div>
    <h2 style="margin-top:20px">Amounts</h2>
    <div class="kv"><span>Total</span><span><?php echo e(formatPrice($r['total_amount'])); ?></span></div>
    <div class="kv"><span>Verified payments</span><span><?php echo e(formatPrice($verified)); ?></span></div>
    <div class="kv"><span>Balance due</span><strong><?php echo e(formatPrice($balance)); ?></strong></div>
  </div>
</div>

<div class="panel">
  <h2>Order</h2>
  <?php if ($r['package_name']): ?>
    <div class="kv"><span>Package</span><span><?php echo e($r['package_name']); ?></span></div>
    <?php foreach ($menu_by_cat as $cat => $items): ?>
      <div class="kv"><span><?php echo e($cat); ?></span><span><?php echo e(implode(', ', $items)); ?></span></div>
    <?php endforeach; ?>
  <?php endif; ?>
  <?php foreach ($trays as $t): ?>
    <div class="kv"><span>Tray</span><span><?php echo e($t['name']); ?> × <?php echo (int)$t['quantity']; ?> (<?php echo e(formatPrice($t['price'] * $t['quantity'])); ?>)</span></div>
  <?php endforeach; ?>
  <?php if (!$r['package_name'] && !$trays): ?><div class="empty">No items recorded.</div><?php endif; ?>
</div>

<div class="panel">
  <h2>Payments</h2>
  <?php if (!$pays): ?><div class="empty">No payment submitted.</div><?php endif; ?>
  <?php foreach ($pays as $p):
      $url = BASE_URL . $p['payment_proof'];
      $is_pdf = strtolower(pathinfo($p['payment_proof'], PATHINFO_EXTENSION)) === 'pdf'; ?>
    <div class="paybox">
      <div class="kv"><span>Reference</span><span><?php echo e($p['reference_number']); ?></span></div>
      <div class="kv"><span>Method / amount</span><span><?php echo e($p['payment_method']); ?> · <?php echo e(formatPrice($p['amount_paid'])); ?></span></div>
      <div class="kv"><span>Submitted</span><span><?php echo e(date('M d, Y g:i A', strtotime($p['payment_date']))); ?></span></div>
      <div class="kv"><span>Status</span><span><?php echo statusPill($p['status']); ?></span></div>
      <?php if ($p['admin_note']): ?><div class="kv"><span>Reason</span><span><?php echo e($p['admin_note']); ?></span></div><?php endif; ?>
      <?php if ($is_pdf): ?><p><a href="<?php echo e($url); ?>" target="_blank" rel="noopener">Open PDF proof</a></p>
      <?php else: ?><a href="<?php echo e($url); ?>" target="_blank" rel="noopener"><img class="proof" src="<?php echo e($url); ?>" alt="Payment proof"></a><?php endif; ?>

      <?php if ($p['status'] === 'Pending' && $r['status'] === 'Pending'): ?>
      <form method="POST">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="payment_id" value="<?php echo (int)$p['id']; ?>">
        <?php if ($conflict): ?><div class="warn">Another approved event is already on this date. <label><input type="checkbox" name="force" value="1"> Approve anyway</label></div><?php endif; ?>
        <textarea name="note" rows="2" placeholder="Reason (required only when rejecting)"></textarea>
        <button class="btn btn-green" name="action" value="verify">Verify &amp; approve</button>
        <button class="btn btn-red" name="action" value="reject">Reject proof</button>
      </form>
      <?php endif; ?>
    </div>
  <?php endforeach; ?>
</div>

<?php if (in_array($r['status'], ['Pending','Approved','Completed'], true)): ?>
<div class="panel">
  <h2>Actions</h2>
  <div style="display:flex;gap:10px;flex-wrap:wrap;margin-bottom:14px">
    <?php if ($r['status'] === 'Approved'): ?>
      <form method="POST"><?php echo csrf_field(); ?><button class="btn btn-green" name="action" value="complete" onclick="return confirm('Mark this event as completed?')">Mark completed</button></form>
    <?php endif; ?>
    <?php if (in_array($r['status'], ['Approved','Completed'], true) && !$r['balance_paid']): ?>
      <form method="POST"><?php echo csrf_field(); ?><button class="btn btn-gold" name="action" value="balance" onclick="return confirm('Mark the remaining balance as fully paid?')">Mark balance paid</button></form>
    <?php endif; ?>
  </div>
  <?php if (in_array($r['status'], ['Pending','Approved'], true)): ?>
  <form method="POST">
    <?php echo csrf_field(); ?>
    <textarea name="note" rows="2" placeholder="Cancellation reason (shown to the customer)" required></textarea>
    <button class="btn btn-red" name="action" value="cancel" onclick="return confirm('Cancel this reservation?')">Cancel reservation</button>
  </form>
  <?php endif; ?>
</div>
<?php endif; ?>
<?php include __DIR__ . '/includes/admin_footer.php'; ?>
