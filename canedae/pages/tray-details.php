<?php
// pages/tray-details.php – Detailed view of a food tray
require_once '../config/db.php';
require_once '../includes/booking_flow.php';
startSession();

$db = getDB();
$tray_id = intval($_GET['id'] ?? 1);

$stmt = $db->prepare("SELECT * FROM trays WHERE id = ? AND is_active = 1");
$stmt->execute([$tray_id]);
$tray = $stmt->fetch();

if (!$tray) {
    redirect(BASE_URL . 'pages/trays.php');
}

if (isset($_GET['add_to_order']) && bookingInProgress()) {
    if (!isset($_SESSION['booking']['trays'])) {
        $_SESSION['booking']['trays'] = [];
    }
    $_SESSION['booking']['trays'][$tray_id] = max(1, $_SESSION['booking']['trays'][$tray_id] ?? 1);
    redirect(BASE_URL . 'pages/event-details.php');
}

$in_booking = bookingInProgress();

$page_title = $tray['name'];
include '../includes/header.php';
if ($in_booking) {
    $current_step = 'trays';
    $flow_type    = 'tray';
    include '../includes/booking_steps.php';
}

// Build inclusions list
$inclusions = [];
if (!empty($tray['inclusions'])) {
    $inclusions = array_values(array_filter(array_map('trim', explode("\n", $tray['inclusions']))));
}
if (empty($inclusions)) {
    $inclusions = ['Native Chicken Adobo','Native Chicken Tinola','Buttered Chicken',
                   'Chicken Cordon Bleu','Chicken Joy','Chicken Lolipop',
                   'Chicken Lumpia Shanghai','Chicken Kare-Kare'];
}

$image_src = BASE_URL . $tray['image'];
$pax_label = ($tray['pax_min'] && $tray['pax_max'])
    ? 'Good for ' . $tray['pax_min'] . '-' . $tray['pax_max'] . ' pax'
    : 'Customize your tray';
$price_display = ($tray['price'] > 0)
    ? 'P ' . number_format($tray['price'], 0)
    : 'P ---';
?>

<div style="max-width: 880px; margin: 32px auto 60px; padding: 0 20px;">

  <!-- Title & pax -->
  <div style="margin-bottom: 22px;">
    <h1 style="font-family:'Playfair Display', serif; font-size: 2.2rem; font-weight: 700; color: #1a140e; margin-bottom: 4px;">
      <?php echo htmlspecialchars($tray['name']); ?>
    </h1>
    <p style="font-family:'Playfair Display', serif; font-size: 1.05rem; color: #3a2e22;">
      <?php echo htmlspecialchars($pax_label); ?>
    </p>
  </div>

  <!-- Single white card -->
  <div class="design-card" style="padding: 28px 32px;">

    <!-- Photo + Inclusions row (flex-wrap for responsiveness) -->
    <div style="display: flex; gap: 28px; flex-wrap: wrap; align-items: flex-start; margin-bottom: 28px;">

      <!-- Photo -->
      <div style="flex: 0 0 auto; width: 260px; max-width: 100%;">
        <div style="width:100%; aspect-ratio: 4/3; overflow:hidden; border: 1px solid #dcd5ca;
                    box-shadow: 0 4px 14px rgba(0,0,0,0.12); border-radius: 6px;">
          <img src="<?php echo htmlspecialchars($image_src); ?>"
               alt="<?php echo htmlspecialchars($tray['name']); ?>"
               style="width:100%; height:100%; object-fit:cover; display:block;"
               onerror="this.src='https://images.unsplash.com/photo-1569058242253-92a9c755a0ec?w=600'">
        </div>
      </div>

      <!-- Inclusions list -->
      <div style="flex:1; min-width: 200px;">
        <h3 style="font-family:'Playfair Display', serif; font-size: 1.15rem; font-weight: 700;
                   color: #1a140e; margin-bottom: 14px;">
          Tray Inclusion:
        </h3>
        <ul style="list-style: disc; padding-left: 22px; line-height: 1.9;
                   font-size: 0.95rem; color: #22170f; margin:0;">
          <?php foreach ($inclusions as $inc): ?>
            <li><?php echo htmlspecialchars($inc); ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>

    <!-- Price + Buttons row -->
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;
                border-top: 1px dashed #b8a88a; padding-top: 22px;">
      <div style="font-family:'Cinzel', serif; font-size: 2.3rem; font-weight: 800; color: #2e5c1e;">
        <?php echo $price_display; ?>
      </div>
      <div style="display:flex; gap:14px; flex-wrap:wrap;">
        <a href="<?php echo BASE_URL; ?>pages/trays.php" class="btn-navy" style="padding: 10px 24px;">
          All Trays
        </a>
        <?php if ($in_booking): ?>
          <a href="<?php echo BASE_URL; ?>pages/tray-details.php?id=<?php echo $tray['id']; ?>&add_to_order=1"
             class="btn-forest" style="padding: 10px 24px;">
            Add Tray &amp; Proceed
          </a>
        <?php else: ?>
          <a href="<?php echo BASE_URL; ?>pages/calendar.php" class="btn-forest" style="padding: 10px 22px;">
            Check Availability First
          </a>
        <?php endif; ?>
      </div>
    </div>

  </div>
</div>

<?php include '../includes/footer.php'; ?>
