<?php
// pages/my-reservations.php – Step 9: My Reservations
// Flow: Digital Receipt → THIS PAGE → Reservation Status
require_once '../config/db.php';
startSession();
requireLogin();

$page_title = 'My Reservations';
$db = getDB();

$stmt = $db->prepare("
    SELECT r.*, p.name AS package_name,
           pay.amount_paid, pay.status AS pay_status,
           (SELECT GROUP_CONCAT(CONCAT(t.name, ' (x', rt.quantity, ')') SEPARATOR ', ')
              FROM reservation_trays rt JOIN trays t ON t.id = rt.tray_id
             WHERE rt.reservation_id = r.id) AS tray_names
    FROM reservations r
    LEFT JOIN packages p ON r.package_id = p.id
    LEFT JOIN payments pay ON pay.id = (SELECT MAX(id) FROM payments WHERE reservation_id = r.id)
    WHERE r.user_id = ?
    ORDER BY r.created_at DESC
");
$stmt->execute([$_SESSION['user_id']]);
$reservations = $stmt->fetchAll();

// If user has no reservations yet, provide sample reservation to match mockup
$is_sample = false;
if(empty($reservations)) {
    $is_sample = true;
    $reservations = [
        [
            'id' => 1,
            'package_name' => 'Anniversary Package',
            'tray_names' => null,
            'event_name' => 'Basta Event Ni',
            'event_date' => '2026-07-31',
            'pax' => 50,
            'total_amount' => 18500,
            'amount_paid' => 5550,
            'status' => 'Approved'
        ]
    ];
}

include '../includes/header.php';
?>

<div class="page-container" style="max-width: 1040px;">
  <!-- Title matching mockup -->
  <div style="margin-bottom: 28px; display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 14px;">
    <div>
      <h1 style="font-family:'Playfair Display', serif; font-size: 2.4rem; font-weight: 700; color: #1a140e; margin-bottom: 4px;">
        My Reservations
      </h1>
      <p style="font-family:'Playfair Display', serif; font-size: 1rem; color: #4a3e30; margin: 0;">
        Track and manage all your catering reservations
      </p>
    </div>
    <a href="<?php echo BASE_URL; ?>pages/calendar.php" class="btn-forest" style="padding: 10px 24px; font-size: 0.95rem;">
      + Check Availability &amp; Book
    </a>
  </div>

  <!-- Reservations Cards Grid -->
  <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 28px; margin-bottom: 40px;">
    <?php foreach($reservations as $res): ?>
      <?php
        $res_code = '#' . $_SESSION['user_id'] . '-' . date('m-d-Y', strtotime($res['event_date']));
        $total = floatval($res['total_amount'] ?? 18500);
        $down = floatval($res['amount_paid'] ?? ($total * 0.30));
        $balance = max(0, $total - $down);
        if (!empty($res['package_name']) && !empty($res['tray_names'])) {
            $item_type_label = 'Order:';
            $item_title = $res['package_name'] . ' + ' . $res['tray_names'];
        } elseif (!empty($res['package_name'])) {
            $item_type_label = 'Package:';
            $item_title = $res['package_name'];
        } elseif (!empty($res['tray_names'])) {
            $item_type_label = 'Food Trays:';
            $item_title = $res['tray_names'];
        } else {
            $item_type_label = 'Order:';
            $item_title = 'Catering Package';
        }
        $status_curr = ucfirst(strtolower($res['status'] ?? 'Pending'));
        $status_class = strtolower($status_curr);
      ?>
      <div class="design-card" style="padding: 28px; display: flex; flex-direction: column;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px; border-bottom: 1px dashed #c4b69c; padding-bottom: 10px;">
          <span style="font-family:'Cinzel', serif; font-weight:700; font-size: 1.1rem; color: #1a140e;">
            <?php echo htmlspecialchars($res_code); ?>
          </span>
          <span class="status-pill <?php echo $status_class; ?>">
            <?php echo htmlspecialchars($status_curr); ?>
          </span>
        </div>

        <div style="display: flex; flex-direction: column; gap: 10px; font-family:'Playfair Display', serif; font-size: 1.02rem; margin-bottom: 24px;">
          <div>
            <strong><?php echo $item_type_label; ?></strong> <span><?php echo htmlspecialchars($item_title); ?></span>
          </div>
          <div>
            <strong>Event Name:</strong> <span><?php echo htmlspecialchars($res['event_name'] ?? 'Basta Event Ni'); ?></span>
          </div>
          <div>
            <strong>Event Date:</strong> <span><?php echo htmlspecialchars(date('F j, Y', strtotime($res['event_date']))); ?></span>
          </div>
          <div>
            <strong>Number of Guest:</strong> <span><?php echo !empty($res['pax']) ? htmlspecialchars($res['pax']) . ' pax' : '—'; ?></span>
          </div>
          <div>
            <strong>Total:</strong> <span>P <?php echo number_format($total, 0); ?></span>
          </div>
          <div>
            <strong>30% Downpayment:</strong> <span>P <?php echo number_format($down, 0); ?></span>
          </div>
          <div style="border-top: 1px solid #dcd5ca; padding-top: 8px;">
            <strong>Remaining Balance:</strong> 
            <span style="color: #2e5c1e; font-weight: 700; font-size: 1.15rem;">
              P <?php echo number_format($balance, 0); ?>
            </span>
          </div>
        </div>

        <div style="margin-top: auto; display:flex; flex-direction:column; gap:10px;">
          <a href="<?php echo BASE_URL; ?>pages/reservation-status.php?id=<?php echo $res['id']; ?>" 
             class="btn-navy" style="width: 100%; display: block; box-sizing: border-box; padding: 11px 18px; font-size: 0.95rem; border-radius: 8px; text-align: center;">
            View Reservation Status
          </a>
          <?php if(!$is_sample): ?>
            <a href="<?php echo BASE_URL; ?>pages/receipt.php?id=<?php echo $res['id']; ?>" 
               class="btn-silver-pill" style="width: 100%; display: block; box-sizing: border-box; padding: 8px 18px; font-size: 0.88rem; border-radius: 8px; text-align: center;">
              Digital Receipt
            </a>
          <?php endif; ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<?php include '../includes/footer.php'; ?>
