<?php
// pages/summary.php – Step 6: Reservation Summary
// Flow: Event Details → THIS PAGE → Payment / 30% Downpayment
require_once '../config/db.php';
require_once '../includes/booking_flow.php';
startSession();
requireLogin();
requireBookingProgress(4); // every previous step must be complete

$page_title   = 'Reservation Summary';
$current_step = 'summary';

$db     = getDB();
$b      = $_SESSION['booking'];
$totals = bookingCalculateTotals($db);

$package        = $totals['package'];
$package_price  = $totals['package_price'];
$selected_trays = $totals['trays'];

// Selected menu items (packages only)
$selected_menu = [];
if ($package && !empty($b['menu_items'])) {
    $placeholders = implode(',', array_fill(0, count($b['menu_items']), '?'));
    $mi_stmt = $db->prepare("SELECT * FROM menu_items WHERE id IN ($placeholders) ORDER BY category, item_name");
    $mi_stmt->execute(array_values($b['menu_items']));
    foreach ($mi_stmt->fetchAll() as $mi) {
        $selected_menu[$mi['category']][] = $mi['item_name'];
    }
}

include '../includes/header.php';
include '../includes/booking_steps.php';
?>

<div class="flow-wrap" style="max-width: 860px;">
  <h1 class="flow-heading">Reservation Summary</h1>
  <p class="flow-subheading">Please review your complete reservation breakdown before proceeding to payment.</p>

  <div class="flow-card">

    <!-- Date & Time -->
    <div class="flow-section-title">
      <span>📅 Date &amp; Time</span>
      <a href="<?php echo BASE_URL; ?>pages/calendar.php" class="flow-edit-link">Edit Date</a>
    </div>
    <div class="summary-row">
      <span class="label">Event Date</span>
      <span class="value"><?php echo date('F j, Y (l)', strtotime($b['date'])); ?></span>
    </div>
    <div class="summary-row">
      <span class="label">Event Time</span>
      <span class="value"><?php echo date('g:i A', strtotime($b['event_time'] ?? '08:30')); ?></span>
    </div>

    <!-- Package (if selected) -->
    <?php if ($package): ?>
      <div class="flow-section-title">
        <span>📦 Catering Package</span>
        <a href="<?php echo BASE_URL; ?>pages/packages.php" class="flow-edit-link">Change Package</a>
      </div>
      <div class="summary-row">
        <span class="label">Package</span>
        <span class="value"><?php echo htmlspecialchars($package['name']); ?></span>
      </div>
      <div class="summary-row">
        <span class="label">Package Price</span>
        <span class="value">P <?php echo number_format($package_price, 2); ?></span>
      </div>

      <!-- Menu Customization -->
      <?php if (!empty($selected_menu)): ?>
        <div class="flow-section-title">
          <span>🍽️ Customized Menu</span>
          <a href="<?php echo BASE_URL; ?>pages/menu.php" class="flow-edit-link">Edit Menu</a>
        </div>
        <?php foreach ($selected_menu as $cat => $items): ?>
          <div class="summary-row" style="align-items:flex-start;">
            <span class="label"><?php echo htmlspecialchars($cat); ?></span>
            <span class="value"><?php echo implode(', ', array_map('htmlspecialchars', $items)); ?></span>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    <?php endif; ?>

    <!-- Food Trays (if selected, or link to add) -->
    <div class="flow-section-title">
      <span>🍱 Food Trays <?php echo $package ? '(Add-ons)' : '(Main Order)'; ?></span>
      <a href="<?php echo BASE_URL; ?>pages/trays.php" class="flow-edit-link">
        <?php echo !empty($selected_trays) ? 'Edit Trays' : '+ Add Food Trays'; ?>
      </a>
    </div>

    <?php if (!empty($selected_trays)): ?>
      <?php foreach ($selected_trays as $titem): ?>
        <div class="summary-row">
          <span class="label">
            <?php echo htmlspecialchars($titem['tray']['name']); ?> &times; <?php echo $titem['quantity']; ?>
            <small style="color:#888;">(P <?php echo number_format($titem['unit_price'], 2); ?> each)</small>
          </span>
          <span class="value">P <?php echo number_format($titem['subtotal'], 2); ?></span>
        </div>
      <?php endforeach; ?>
      <div class="summary-row" style="background:#fcfbf8;">
        <span class="label" style="font-weight:700;">Trays Subtotal</span>
        <span class="value" style="color:#2b551c;">P <?php echo number_format($totals['trays_total'], 2); ?></span>
      </div>
    <?php else: ?>
      <div class="summary-row">
        <span class="label">Food Trays</span>
        <span class="value" style="color:#888; font-weight:normal;">
          No extra food trays selected.
          <a href="<?php echo BASE_URL; ?>pages/trays.php" style="color:#2a5da8; text-decoration:underline; margin-left:6px;">Add Food Trays?</a>
        </span>
      </div>
    <?php endif; ?>

    <!-- Event Details -->
    <div class="flow-section-title">
      <span>🎉 Event Details</span>
      <a href="<?php echo BASE_URL; ?>pages/event-details.php" class="flow-edit-link">Edit Details</a>
    </div>
    <div class="summary-row">
      <span class="label">Event Name</span>
      <span class="value"><?php echo htmlspecialchars($b['event_name']); ?></span>
    </div>
    <div class="summary-row">
      <span class="label">Event Type</span>
      <span class="value"><?php echo htmlspecialchars($b['event_type'] ?? '—'); ?></span>
    </div>
    <div class="summary-row">
      <span class="label">Venue / Address</span>
      <span class="value"><?php echo htmlspecialchars($b['event_venue']); ?></span>
    </div>
    <div class="summary-row">
      <span class="label">Number of Guests</span>
      <span class="value"><?php echo intval($b['pax'] ?? 0) > 0 ? intval($b['pax']) . ' pax' : '—'; ?></span>
    </div>
    <div class="summary-row">
      <span class="label">Contact Person</span>
      <span class="value"><?php echo htmlspecialchars($b['full_name'] ?? ''); ?></span>
    </div>
    <div class="summary-row">
      <span class="label">Contact Number</span>
      <span class="value"><?php echo htmlspecialchars($b['contact_number'] ?? ''); ?></span>
    </div>
    <div class="summary-row">
      <span class="label">Email Address</span>
      <span class="value"><?php echo htmlspecialchars($b['email'] ?? ''); ?></span>
    </div>
    <?php if (!empty($b['special'])): ?>
      <div class="summary-row" style="align-items:flex-start;">
        <span class="label">Special Requests</span>
        <span class="value"><?php echo nl2br(htmlspecialchars($b['special'])); ?></span>
      </div>
    <?php endif; ?>

    <!-- Totals Calculation -->
    <div style="border-top:2px solid #2b1f14; margin-top:18px; padding-top:12px;">
      <?php if ($package && !empty($selected_trays)): ?>
        <div class="summary-row">
          <span class="label">Package Subtotal</span>
          <span class="value">P <?php echo number_format($package_price, 2); ?></span>
        </div>
        <div class="summary-row">
          <span class="label">Food Trays Subtotal</span>
          <span class="value">P <?php echo number_format($totals['trays_total'], 2); ?></span>
        </div>
      <?php endif; ?>

      <div class="summary-total">
        <span>Grand Total Amount</span>
        <span>P <?php echo number_format($totals['grand_total'], 2); ?></span>
      </div>
      <div class="summary-row" style="font-size:1.05rem; padding:12px 0 6px;">
        <span class="label" style="font-weight:700; color:#1a140e;">Downpayment Due Now (30%)</span>
        <span class="value" style="color:#2e5c1e; font-size:1.2rem; font-weight:800;">
          P <?php echo number_format($totals['downpayment'], 2); ?>
        </span>
      </div>
      <div class="summary-row">
        <span class="label">Remaining Balance (due on event day)</span>
        <span class="value">P <?php echo number_format($totals['balance'], 2); ?></span>
      </div>
    </div>

    <div class="alert alert-warning" style="margin:20px 0 0;">
      <i class="fa fa-info-circle"></i>
      A <strong>30% downpayment</strong> (P <?php echo number_format($totals['downpayment'], 2); ?>) is required to secure your reservation.
      The remaining balance of P <?php echo number_format($totals['balance'], 2); ?> is due on the day of the event.
    </div>
  </div>

  <div class="flow-actions">
    <a href="<?php echo BASE_URL; ?>pages/event-details.php" class="btn-flow-back">Event Details</a>
    <a href="<?php echo BASE_URL; ?>pages/payment.php" class="btn-flow-next" id="proceedToPaymentBtn">
      Confirm &amp; Proceed to Payment
    </a>
  </div>
</div>

<?php include '../includes/footer.php'; ?>
