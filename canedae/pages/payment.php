<?php
// pages/payment.php – Step 7: Payment / 30% Downpayment
// Flow: Reservation Summary → THIS PAGE → Digital Receipt
require_once '../config/db.php';
require_once '../includes/booking_flow.php';
startSession();
requireLogin();
requireBookingProgress(4); // summary must be reachable (all details complete)

$page_title = 'Payment Details';
$current_step = 'payment';
$db = getDB();
$b = $_SESSION['booking'];

$totals = bookingCalculateTotals($db);
$package = $totals['package'];
$package_price = $totals['package_price'];
$selected_trays = $totals['trays'];
$total_amount = $totals['grand_total'];
$downpayment = $totals['downpayment']; // 30% downpayment
$amount_payable = $downpayment;
$remaining_balance = $totals['balance'];

$event_date = $b['date']; // Y-m-d
$pax = intval($b['pax'] ?? 0);

// Reservation ID format from mockup: #1-07-31-2026
$res_display_id = '#' . $_SESSION['user_id'] . '-' . date('m-d-Y', strtotime($event_date));

$allowed_methods = ['GCash'];

// GCash details are managed by the admin (Admin > Payment settings)
$gcash = ['gcash_name' => '', 'gcash_number' => '', 'gcash_qr' => ''];
try {
  $rows = $db->query("SELECT setting_key, setting_value FROM settings WHERE setting_key IN ('gcash_name','gcash_number','gcash_qr')")->fetchAll();
  foreach ($rows as $r)
    $gcash[$r['setting_key']] = $r['setting_value'];
} catch (Throwable $e) { /* settings table not created yet */
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_payment'])) {
  $payment_method = $_POST['payment_method'] ?? 'GCash';
  if (!in_array($payment_method, $allowed_methods, true)) {
    $payment_method = 'GCash';
  }

  // Validate proof upload (required for downpayment)
  $has_file = isset($_FILES['payment_proof']) && $_FILES['payment_proof']['error'] === UPLOAD_ERR_OK;
  $ext = $has_file ? strtolower(pathinfo($_FILES['payment_proof']['name'], PATHINFO_EXTENSION)) : '';
  if (empty($_POST['agree_terms'])) {
    $error = 'Please agree to the Terms and Conditions to continue.';
  } elseif (!$has_file) {
    $error = 'Please upload your proof of payment for the 30% downpayment.';
  } elseif (!in_array($ext, ['jpg', 'jpeg', 'png', 'pdf'])) {
    $error = 'Invalid file type. Accepted files: JPG, PNG, PDF.';
  } elseif ($_FILES['payment_proof']['size'] > 5 * 1024 * 1024) {
    $error = 'File is too large. Maximum size is 5 MB.';
  }

  if (!$error) {
    try {
      $db->beginTransaction();

      // 1. Reservation record
      $ins_res = $db->prepare("INSERT INTO reservations
                (user_id, package_id, event_name, event_date, event_time, event_venue, event_type, pax, special_requests, total_amount, status)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending')");
      $ins_res->execute([
        $_SESSION['user_id'],
        $package ? intval($package['id']) : null,
        $b['event_name'],
        date('Y-m-d', strtotime($event_date)),
        date('H:i:s', strtotime($b['event_time'] ?? '08:30')),
        $b['event_venue'],
        $b['event_type'] ?? null,
        $pax,
        $b['special'] ?? '',
        $total_amount,
      ]);
      $reservation_id = $db->lastInsertId();

      // 2. Customized menu (packages)
      if ($package && !empty($b['menu_items'])) {
        $ins_menu = $db->prepare("INSERT INTO reservation_menu (reservation_id, menu_item_id) VALUES (?, ?)");
        foreach ($b['menu_items'] as $mid) {
          $ins_menu->execute([$reservation_id, intval($mid)]);
        }
      }

      // 3. Selected Food Trays (can exist alongside package, or trays alone)
      if (!empty($selected_trays)) {
        $ins_tray = $db->prepare("INSERT INTO reservation_trays (reservation_id, tray_id, quantity) VALUES (?, ?, ?)");
        foreach ($selected_trays as $titem) {
          $ins_tray->execute([$reservation_id, intval($titem['tray']['id']), intval($titem['quantity'])]);
        }
      }

      // 4. Payment proof upload
      $upload_dir = '../assets/uploads/payments/';
      if (!is_dir($upload_dir))
        mkdir($upload_dir, 0755, true);
      $filename = 'pay_' . $reservation_id . '_' . time() . '.' . $ext;
      $proof_path = 'assets/uploads/payments/' . $filename;
      if (!move_uploaded_file($_FILES['payment_proof']['tmp_name'], $upload_dir . $filename)) {
        throw new RuntimeException('Could not save the uploaded file.');
      }

      // 5. Payment record (30% downpayment, pending verification)
      $ref_no = 'REF-' . strtoupper(uniqid());
      $ins_pay = $db->prepare("INSERT INTO payments
                (reservation_id, reference_number, payment_method, amount_paid, payment_proof, status)
                VALUES (?, ?, ?, ?, ?, 'Pending')");
      $ins_pay->execute([$reservation_id, $ref_no, $payment_method, $amount_payable, $proof_path]);

      $db->commit();
    } catch (Throwable $e) {
      if ($db->inTransaction())
        $db->rollBack();
      $error = 'Something went wrong while saving your reservation. Please try again.';
    }

    if (!$error) {
      // Store for receipt, then clear the booking wizard
      $_SESSION['last_res_id'] = $reservation_id;
      $_SESSION['last_res_display_id'] = $res_display_id;
      $_SESSION['last_payment_method'] = $payment_method;
      unset($_SESSION['booking']);

      redirect(BASE_URL . 'pages/receipt.php?id=' . $reservation_id);
    }
  }
}

include '../includes/header.php';
include '../includes/booking_steps.php';
?>

<div class="page-container" style="max-width: 960px;">
  <!-- Title & Subtitle matching the mockup -->
  <div style="margin-bottom: 24px;">
    <h1
      style="font-family:'Playfair Display', serif; font-size: 2.4rem; font-weight: 700; color: #1a140e; margin-bottom: 2px;">
      Payment Details
    </h1>
    <p style="font-family:'Playfair Display', serif; font-size: 1.05rem; color: #4a3e30;">
      Reservation ID: <?php echo htmlspecialchars($res_display_id); ?> &nbsp;·&nbsp; Pay 30% downpayment to secure your
      date
    </p>
  </div>

  <?php if ($error): ?>
    <div
      style="background:#fee2e2; border:1px solid #ef4444; color:#991b1b; padding:12px 18px; border-radius:8px; margin-bottom:20px;">
      <?php echo htmlspecialchars($error); ?>
    </div>
  <?php endif; ?>

  <form method="POST" enctype="multipart/form-data" id="paymentForm">
    <input type="hidden" name="confirm_payment" value="1">
    <input type="hidden" name="payment_method" id="selectedPaymentMethod" value="GCash">

    <div class="payment-layout-grid">
      <!-- Left Card: Cost Breakdown -->
      <div class="design-card" style="padding: 32px 36px;">
        <div
          style="display: flex; flex-direction: column; gap: 14px; font-family:'Playfair Display', serif; font-size: 1.05rem;">
          <?php if ($package): ?>
            <div style="display: flex; justify-content: space-between; gap: 12px;">
              <strong>Package:</strong>
              <span style="text-align:right;"><?php echo htmlspecialchars($package['name']); ?></span>
            </div>
          <?php endif; ?>

          <?php if (!empty($selected_trays)): ?>
            <div style="display: flex; justify-content: space-between; gap: 12px;">
              <strong>Food Trays:</strong>
              <span style="text-align:right;">
                <?php
                $tlabels = array_map(fn($t) => htmlspecialchars($t['tray']['name']) . ' (x' . $t['quantity'] . ')', $selected_trays);
                echo implode(', ', $tlabels);
                ?>
              </span>
            </div>
          <?php endif; ?>

          <div style="display: flex; justify-content: space-between;">
            <strong>Event Date:</strong>
            <span><?php echo htmlspecialchars(date('m-d-Y', strtotime($event_date))); ?></span>
          </div>
          <div style="display: flex; justify-content: space-between;">
            <strong>Number of Guest:</strong>
            <span><?php echo $pax > 0 ? $pax : '—'; ?></span>
          </div>

          <div style="border-top: 1px dotted #888888; margin: 6px 0;"></div>

          <div style="display: flex; justify-content: space-between;">
            <strong>Total Amount:</strong>
            <span>P <?php echo number_format($total_amount, 0); ?></span>
          </div>
          <div style="display: flex; justify-content: space-between;">
            <strong>Downpayment (30%):</strong>
            <span>P <?php echo number_format($downpayment, 0); ?></span>
          </div>
          <div style="display: flex; justify-content: space-between;">
            <strong>Amount Payable Now:</strong>
            <span style="font-weight:700; color:#2a5da8;">P <?php echo number_format($amount_payable, 0); ?></span>
          </div>

          <div style="border-top: 1px solid #33261a; margin: 12px 0 6px;"></div>

          <div style="display: flex; justify-content: space-between; align-items: center;">
            <strong style="font-size: 1.1rem;">Remaining Balance:</strong>
            <span style="font-family:'Cinzel', serif; font-size: 1.9rem; font-weight: 800; color: #2e5c1e;">
              P <?php echo number_format($remaining_balance, 0); ?>
            </span>
          </div>
        </div>
      </div>

      <!-- Right Card: Payment Method & Proof Upload -->
      <div class="design-card" style="padding: 32px 36px;">
        <h3
          style="font-family:'Playfair Display', serif; font-size: 1.1rem; font-weight: 700; color: #1a140e; margin-bottom: 14px;">
          Pay via GCash
        </h3>

        <div style="text-align:center;">
          <?php if (!empty($gcash['gcash_qr'])): ?>
            <img src="<?php echo BASE_URL . htmlspecialchars($gcash['gcash_qr']); ?>" alt="GCash QR code"
              style="max-width:220px; width:100%; border:1px solid #d8cdb8; border-radius:10px; padding:8px; background:#fff;">
          <?php else: ?>
            <p style="color:#8a1f1f; font-size:0.9rem;">The GCash QR code is not available yet. Please contact us before
              paying.</p>
          <?php endif; ?>
        </div>
        <div
          style="display:flex; flex-direction:column; gap:8px; margin-top:14px; font-family:'Playfair Display', serif; font-size:1.02rem;">
          <div style="display:flex; justify-content:space-between; gap:12px;">
            <strong>Account Name:</strong><span><?php echo htmlspecialchars($gcash['gcash_name'] ?: '—'); ?></span>
          </div>
          <div style="display:flex; justify-content:space-between; gap:12px;">
            <strong>GCash Number:</strong><span><?php echo htmlspecialchars($gcash['gcash_number'] ?: '—'); ?></span>
          </div>
        </div>
        <p style="font-size:0.82rem; color:#5a4b3c; margin-top:10px;">
          Scan the QR code or send <strong>P <?php echo number_format($amount_payable, 0); ?></strong> to the number
          above, then upload your screenshot below.
        </p>

        <div style="border-top: 1px dotted #888888; margin: 20px 0 16px;"></div>

        <h3
          style="font-family:'Playfair Display', serif; font-size: 1.1rem; font-weight: 700; color: #1a140e; margin-bottom: 12px;">
          Upload Proof of 30% Downpayment: *
        </h3>

        <div style="margin-bottom: 8px;">
          <input type="file" name="payment_proof" id="paymentProofInput" class="form-input-bordered"
            accept=".jpg,.jpeg,.png,.pdf" style="padding: 8px 10px;" required>
        </div>
        <p style="font-size: 0.8rem; color: #5a4b3c; margin-bottom: 24px;">
          Accepted File: JPG, PNG, PDF (max 5 MB)
        </p>

        <label
          style="display:flex; gap:8px; align-items:flex-start; font-size:0.9rem; margin-bottom:16px; color:#33261a;">
          <input type="checkbox" name="agree_terms" value="1" required style="margin-top:3px;">
          <span>I have read and agree to the <a href="<?php echo BASE_URL; ?>pages/terms.php" target="_blank"
              rel="noopener" style="text-decoration:underline;">Terms and Conditions</a>.</span>
        </label>

        <button type="submit" class="btn-forest" style="width: 100%; padding: 12px; font-size: 1.05rem;"
          id="confirmPaymentBtn">
          Confirm Payment (P <?php echo number_format($amount_payable, 0); ?>)
        </button>
      </div>
    </div>

    <div class="flow-actions">
      <a href="<?php echo BASE_URL; ?>pages/summary.php" class="btn-flow-back">Reservation Summary</a>
    </div>
  </form>
</div>

<?php include '../includes/footer.php'; ?>