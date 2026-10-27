<?php
// pages/reservation-status.php – customer view of one reservation + re-upload after a rejected proof
require_once '../config/db.php';
startSession();
requireLogin();
$page_title = 'Reservation Status';
$db = getDB();
$id = intval($_GET['id'] ?? 0);

$st = $db->prepare("SELECT r.*, p.name AS package_name FROM reservations r
    LEFT JOIN packages p ON p.id = r.package_id WHERE r.id = ? AND r.user_id = ?");
$st->execute([$id, $_SESSION['user_id']]);
$r = $st->fetch();
if (!$r) {
    $_SESSION['flash'] = ['type' => 'warning', 'message' => 'Reservation not found.'];
    redirect(BASE_URL . 'pages/my-reservations.php');
}

$ps = $db->prepare("SELECT * FROM payments WHERE reservation_id = ? ORDER BY id DESC LIMIT 1");
$ps->execute([$id]);
$pay = $ps->fetch();
$can_reupload = $pay && $pay['status'] === 'Rejected' && $r['status'] === 'Pending';

$error = '';
if ($can_reupload && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $ok  = isset($_FILES['payment_proof']) && $_FILES['payment_proof']['error'] === UPLOAD_ERR_OK;
    $ext = $ok ? strtolower(pathinfo($_FILES['payment_proof']['name'], PATHINFO_EXTENSION)) : '';
    if (!$ok) $error = 'Please choose your proof of payment.';
    elseif (!in_array($ext, ['jpg','jpeg','png','pdf'], true)) $error = 'Invalid file type. Accepted: JPG, PNG, PDF.';
    elseif ($_FILES['payment_proof']['size'] > 5 * 1024 * 1024) $error = 'File is too large. Maximum is 5 MB.';
    else {
        $dir = __DIR__ . '/../assets/uploads/payments/';
        if (!is_dir($dir)) mkdir($dir, 0755, true);
        $fname = 'pay_' . $id . '_' . time() . '.' . $ext;
        if (move_uploaded_file($_FILES['payment_proof']['tmp_name'], $dir . $fname)) {
            $db->prepare("INSERT INTO payments (reservation_id, reference_number, payment_method, amount_paid, payment_proof, status)
                          VALUES (?, ?, ?, ?, ?, 'Pending')")
               ->execute([$id, 'REF-' . strtoupper(uniqid()), $pay['payment_method'], $pay['amount_paid'], 'assets/uploads/payments/' . $fname]);
            $_SESSION['flash'] = ['type' => 'success', 'message' => 'New proof uploaded. We will review it shortly.'];
            redirect(BASE_URL . 'pages/reservation-status.php?id=' . $id);
        }
        $error = 'Could not save the uploaded file. Please try again.';
    }
}

$msgs = [
    'Pending'   => $pay && $pay['status'] === 'Rejected'
                     ? 'Your payment proof was not accepted. Please upload a new one below.'
                     : 'We received your downpayment proof and will verify it soon.',
    'Approved'  => 'Your reservation is approved. See you at your event!',
    'Completed' => 'This event is completed. Thank you for choosing CaneDae ThirdHome Catering.',
    'Cancelled' => 'This reservation was cancelled.',
];
$status_curr = ucfirst(strtolower($r['status']));
include '../includes/header.php';
?>
<div class="page-container" style="max-width: 760px;">
  <h1 style="font-family:'Playfair Display', serif; font-size:2.2rem; margin-bottom:6px;">Reservation Status</h1>
  <p><span class="status-pill <?php echo strtolower($status_curr); ?>"><?php echo htmlspecialchars($status_curr); ?></span>
     &nbsp;<?php echo htmlspecialchars($msgs[$status_curr] ?? ''); ?></p>

  <div class="design-card" style="padding:24px 28px; margin:18px 0; font-family:'Playfair Display', serif; line-height:1.9;">
    <div><strong>Reservation:</strong> #<?php echo (int)$r['id']; ?></div>
    <div><strong>Event:</strong> <?php echo htmlspecialchars($r['event_name'] ?? ''); ?></div>
    <div><strong>Date:</strong> <?php echo htmlspecialchars(date('F j, Y', strtotime($r['event_date']))); ?>, <?php echo htmlspecialchars(date('g:i A', strtotime($r['event_time']))); ?></div>
    <div><strong>Venue:</strong> <?php echo htmlspecialchars($r['event_venue']); ?></div>
    <?php if ($r['package_name']): ?><div><strong>Package:</strong> <?php echo htmlspecialchars($r['package_name']); ?></div><?php endif; ?>
    <div><strong>Total:</strong> P <?php echo number_format($r['total_amount'], 0); ?></div>
    <?php if ($pay): ?><div><strong>Downpayment:</strong> P <?php echo number_format($pay['amount_paid'], 0); ?> (<?php echo htmlspecialchars($pay['status']); ?>)</div><?php endif; ?>
    <?php if ($pay && $pay['status'] === 'Rejected' && $pay['admin_note']): ?>
      <div><strong>Reason:</strong> <?php echo htmlspecialchars($pay['admin_note']); ?></div>
    <?php endif; ?>
    <?php if ($r['status'] === 'Cancelled' && $r['admin_note']): ?>
      <div><strong>Cancellation reason:</strong> <?php echo htmlspecialchars($r['admin_note']); ?></div>
    <?php endif; ?>
    <?php if ($r['balance_paid']): ?><div><strong>Balance:</strong> Fully paid</div><?php endif; ?>
  </div>

  <?php if ($can_reupload): ?>
    <?php if ($error): ?><div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
    <form method="POST" enctype="multipart/form-data" class="design-card" style="padding:20px 28px;">
      <label><strong>Upload a new proof of payment</strong> (JPG, PNG, PDF · max 5 MB)</label><br>
      <input type="file" name="payment_proof" accept=".jpg,.jpeg,.png,.pdf" required style="margin:10px 0;"><br>
      <button type="submit" class="btn-forest" style="padding:10px 28px;">Submit new proof</button>
    </form>
  <?php endif; ?>

  <p style="margin-top:22px;">
    <a href="<?php echo BASE_URL; ?>pages/my-reservations.php" class="btn-navy" style="padding:10px 24px;">Back to My Reservations</a>
    <a href="<?php echo BASE_URL; ?>pages/receipt.php?id=<?php echo (int)$r['id']; ?>" class="btn-silver-pill" style="padding:9px 20px;">Digital Receipt</a>
  </p>
</div>
<?php include '../includes/footer.php'; ?>
