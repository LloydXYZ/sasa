<?php
// pages/receipt.php – Step 8: Digital Receipt (Flow: Payment → THIS PAGE → My Reservations)
require_once '../config/db.php';
startSession();
requireLogin();

$page_title = 'Digital Receipt';
$db = getDB();

$res_id = intval($_GET['id'] ?? ($_SESSION['last_res_id'] ?? 0));

// Fetch reservation and payment (only the logged-in user's own reservation)
$stmt = $db->prepare("
    SELECT r.*, p.name AS package_name, p.price_min AS pkg_price,
           u.first_name, u.last_name, u.email AS user_email, u.phone AS user_phone,
           pay.payment_method, pay.amount_paid, pay.payment_date, pay.reference_number,
           (SELECT GROUP_CONCAT(CONCAT(t.name, ' (x', rt.quantity, ')') SEPARATOR ', ')
              FROM reservation_trays rt JOIN trays t ON t.id = rt.tray_id
             WHERE rt.reservation_id = r.id) AS tray_names
    FROM reservations r
    LEFT JOIN packages p ON r.package_id = p.id
    LEFT JOIN users u ON r.user_id = u.id
    LEFT JOIN payments pay ON pay.id = (SELECT MAX(id) FROM payments WHERE reservation_id = r.id)
    WHERE r.id = ? AND r.user_id = ?
");
$stmt->execute([$res_id, $_SESSION['user_id']]);
$order = $stmt->fetch();

if (!$order) {
  // Fallback sample data matching the mockup screenshot
  $order = [
    'id' => 1,
    'package_name' => 'Anniversary Package',
    'first_name' => 'Jael',
    'last_name' => 'Castillo',
    'user_phone' => '09123456789',
    'user_email' => 'jaelcastillo@gmail.com',
    'event_date' => '2026-07-31',
    'payment_date' => '2026-07-29',
    'total_amount' => 18500,
    'amount_paid' => 5550,
    'payment_method' => 'Gcash'
  ];
}

$total = floatval($order['total_amount'] ?? 18500);
$downpayment = floatval($order['amount_paid'] ?? ($total * 0.30));
$balance = $total - $downpayment;

$customer_name = trim(($order['first_name'] ?? '') . ' ' . ($order['last_name'] ?? ''));
if (empty($customer_name))
  $customer_name = 'Jael Castillo';

$res_code = '#' . ($order['user_id'] ?? 1) . '-' . date('m-d-Y', strtotime($order['event_date'] ?? '2026-07-31'));
$pay_date = !empty($order['payment_date']) ? date('m-d-Y', strtotime($order['payment_date'])) : '07-29-2026';
$pay_method = $order['payment_method'] ?? 'Gcash';

if (!empty($order['package_name']) && !empty($order['tray_names'])) {
  $item_label = 'Order:';
  $item_name = $order['package_name'] . ' + ' . $order['tray_names'];
} elseif (!empty($order['package_name'])) {
  $item_label = 'Package:';
  $item_name = $order['package_name'];
} elseif (!empty($order['tray_names'])) {
  $item_label = 'Food Trays:';
  $item_name = $order['tray_names'];
} else {
  $item_label = 'Package:';
  $item_name = 'Anniversary Package';
}

$current_step = 'receipt';
$flow_type = (empty($order['package_id']) && !empty($order['tray_names'])) ? 'tray' : 'package';
include '../includes/header.php';
include '../includes/booking_steps.php';
?>

<div class="page-container" style="max-width: 860px;">
  <!-- Header with RECEIPT on left and Reservation ID on right -->
  <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 20px;">
    <h1 style="font-family:'Cinzel', serif; font-size: 2.2rem; font-weight: 700; color: #1a140e; margin: 0;">
      RECEIPT
    </h1>
    <div style="font-family:'Playfair Display', serif; font-size: 1.05rem; color: #3a2e22;">
      Reservation ID: <?php echo htmlspecialchars($res_code); ?>
    </div>
  </div>

  <!-- Digital Receipt Card -->
  <div class="digital-receipt-card" id="printableReceipt">
    <div style="text-align: center; margin-bottom: 16px;">
      <h2
        style="font-family:'Cinzel', serif; font-size: 1.8rem; font-weight: 800; color: #1a140e; letter-spacing: 1px;">
        DIGITAL RECEIPT
      </h2>
      <div style="border-top: 1px solid #4a3e30; margin-top: 12px;"></div>
    </div>

    <!-- 2 Column Details -->
    <div class="receipt-grid-cols">
      <!-- Left Column -->
      <div
        style="display: flex; flex-direction: column; gap: 14px; font-family:'Playfair Display', serif; font-size: 1rem;">
        <div style="display: flex; justify-content: space-between;">
          <strong>Full Name:</strong>
          <span><?php echo htmlspecialchars($customer_name); ?></span>
        </div>
        <div style="display: flex; justify-content: space-between;">
          <strong><?php echo $item_label; ?></strong>
          <span><?php echo htmlspecialchars($item_name); ?></span>
        </div>
        <div style="display: flex; justify-content: space-between;">
          <strong>Date of Payment:</strong>
          <span><?php echo htmlspecialchars($pay_date); ?></span>
        </div>
        <div style="display: flex; justify-content: space-between;">
          <strong>Reservation Id:</strong>
          <span><?php echo htmlspecialchars($res_code); ?></span>
        </div>
        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 6px;">
          <strong>From:</strong>
          <span style="display: flex; align-items: center; gap: 8px; font-weight: 700;">
            <img src="<?php echo BASE_URL; ?>assets/images/logo.png"
              onerror="this.src='<?php echo BASE_URL; ?>assets/images/logo.svg'"
              style="width: 28px; height: 28px; border-radius: 50%;" alt="Logo">
            CaneDae ThirdHome Catering
          </span>
        </div>
        <div style="display: flex; justify-content: space-between; margin-top: 10px;">
          <strong>Total:</strong>
          <span>P <?php echo number_format($total, 0); ?></span>
        </div>
      </div>

      <!-- Right Column -->
      <div
        style="display: flex; flex-direction: column; gap: 14px; font-family:'Playfair Display', serif; font-size: 1rem;">
        <div style="display: flex; justify-content: space-between;">
          <strong>Contact Number:</strong>
          <span><?php echo htmlspecialchars($order['user_phone'] ?? '09123456789'); ?></span>
        </div>
        <div style="display: flex; justify-content: space-between;">
          <strong>Email Address:</strong>
          <span><?php echo htmlspecialchars($order['user_email'] ?? 'jaelcastillo@gmail.com'); ?></span>
        </div>
        <div style="display: flex; justify-content: space-between;">
          <strong>Payment Method:</strong>
          <span
            style="color:#2a5da8; font-weight:700;"><?php echo htmlspecialchars(strcasecmp($pay_method, 'Gcash') === 0 ? 'GCash' : $pay_method); ?></span>
        </div>
        <div style="display: flex; justify-content: space-between; margin-top: 6px;">
          <strong>Downpayment (30%):</strong>
          <span>P <?php echo number_format($downpayment, 0); ?></span>
        </div>
        <div style="display: flex; justify-content: space-between;">
          <strong>Amount Paid:</strong>
          <span style="font-weight: 700; color: #2a5da8;">P <?php echo number_format($downpayment, 0); ?></span>
        </div>
      </div>
    </div>

    <!-- Divider Line -->
    <div style="border-top: 1.5px solid #2b1f14; margin: 18px 0 16px;"></div>

    <!-- Remaining Balance -->
    <div style="display: flex; justify-content: space-between; align-items: center;">
      <strong style="font-family:'Playfair Display', serif; font-size: 1.25rem;">Remaining Balance:</strong>
      <span style="font-family:'Cinzel', serif; font-size: 2.2rem; font-weight: 800; color: #2e5c1e;">
        P <?php echo number_format($balance, 0); ?>
      </span>
    </div>
  </div>

  <!-- Action Buttons below the receipt card -->
  <div style="display: flex; justify-content: space-between; margin-top: 26px;">
    <button type="button" onclick="window.print()" class="btn-navy" style="padding: 10px 32px; font-size: 1rem;">
      Print Receipt
    </button>
    <a href="<?php echo BASE_URL; ?>pages/my-reservations.php" class="btn-forest"
      style="padding: 10px 42px; font-size: 1rem;" id="goToMyReservationsBtn">
      Continue to My Reservations
    </a>
  </div>
</div>

<?php include '../includes/footer.php'; ?>