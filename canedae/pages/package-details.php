<?php
// pages/package-details.php – Package detail view (Step 3b: Package Details → Menu Customization)
require_once '../config/db.php';
require_once '../includes/booking_flow.php';
startSession();

$db = getDB();
$package_id = intval($_GET['id'] ?? 1);

$stmt = $db->prepare("SELECT * FROM packages WHERE id = ? AND is_active = 1");
$stmt->execute([$package_id]);
$package = $stmt->fetch();

if (!$package) {
    redirect(BASE_URL . 'pages/packages.php');
}

$in_booking = bookingInProgress();

$page_title = $package['name'];
include '../includes/header.php';
if ($in_booking) {
    $current_step = 'package';
    $flow_type    = 'package';
    include '../includes/booking_steps.php';
}

// Build inclusions list
$inclusions = [];
if (!empty($package['inclusions'])) {
    $inclusions = array_values(array_filter(array_map('trim', explode("\n", $package['inclusions']))));
}
if (empty($inclusions)) {
    $inclusions = [
        '1 whole 23-25kg Lechon',
        'Beef CH6 Side Dishes (good for 18-20 pax)',
        'Chicken Tray', 'Fish/ Mix Seafood Tray',
        'Veggies Tray', 'Noodles Tray', 'Pork Tray'
    ];
}

$image_src = BASE_URL . $package['image'];
$pax_label = ($package['pax_min'] === $package['pax_max'])
    ? 'Good for ' . $package['pax_min'] . ' pax'
    : 'Good for ' . $package['pax_min'] . '-' . $package['pax_max'] . ' pax';
$price_fmt = 'P ' . number_format($package['price_min'], 0);

// Back link always returns to the package list
$back_url = BASE_URL . 'pages/packages.php';
?>

<!-- Page wrapper, max-width ensures nothing overflows the viewport -->
<div style="max-width: 880px; margin: 32px auto 60px; padding: 0 20px;">

  <!-- Title & pax -->
  <div style="margin-bottom: 22px;">
    <h1 style="font-family:'Playfair Display', serif; font-size: 2.2rem; font-weight: 700; color: #1a140e; margin-bottom: 4px;">
      <?php echo htmlspecialchars($package['name']); ?>
    </h1>
    <p style="font-family:'Playfair Display', serif; font-size: 1.05rem; color: #3a2e22;">
      <?php echo htmlspecialchars($pax_label); ?>
    </p>
  </div>

  <!-- Single white card – stacks into rows on narrow screens -->
  <div class="design-card" style="padding: 28px 32px;">

    <!-- Row 1: Photo + Inclusions side by side on wide screens -->
    <div style="display: flex; gap: 28px; flex-wrap: wrap; align-items: flex-start; margin-bottom: 28px;">

      <!-- Photo -->
      <div style="flex: 0 0 auto; width: 260px; max-width: 100%;">
        <div style="width: 100%; aspect-ratio: 4/3; overflow: hidden; border: 1px solid #dcd5ca;
                    box-shadow: 0 4px 14px rgba(0,0,0,0.12); border-radius: 6px;">
          <img src="<?php echo htmlspecialchars($image_src); ?>"
               alt="<?php echo htmlspecialchars($package['name']); ?>"
               style="width:100%; height:100%; object-fit:cover; display:block;"
               onerror="this.src='https://images.unsplash.com/photo-1530103862676-de8c9debad1d?w=600'">
        </div>
      </div>

      <!-- Inclusions -->
      <div style="flex: 1; min-width: 200px;">
        <h3 style="font-family:'Playfair Display', serif; font-size: 1.15rem; font-weight: 700;
                   color: #1a140e; margin-bottom: 14px;">
          Package Inclusion:
        </h3>
        <ul style="list-style: disc; padding-left: 22px; line-height: 1.9;
                   font-size: 0.95rem; color: #22170f; margin: 0;">
          <?php foreach ($inclusions as $inc): ?>
            <li><?php echo htmlspecialchars($inc); ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>

    <!-- Row 2: Price + Buttons -->
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;
                border-top: 1px dashed #b8a88a; padding-top: 22px;">
      <div style="font-family:'Cinzel', serif; font-size: 2.3rem; font-weight: 800; color: #2e5c1e;">
        <?php echo $price_fmt; ?>
      </div>
      <div style="display: flex; gap: 14px; flex-wrap: wrap;">
        <a href="<?php echo $back_url; ?>" class="btn-navy" style="padding: 10px 22px;">
          Packages
        </a>
        <?php if ($in_booking): ?>
          <a href="<?php echo BASE_URL; ?>pages/trays.php?skip_package=1" class="btn-silver-pill" style="padding: 10px 18px;">
            Order Trays Only
          </a>
          <a href="<?php echo BASE_URL; ?>pages/menu.php?package_id=<?php echo $package['id']; ?>"
             class="btn-forest" style="padding: 10px 22px;" id="proceedToMenuBtn">
            Customize Menu
          </a>
        <?php else: ?>
          <a href="<?php echo BASE_URL; ?>pages/calendar.php" class="btn-forest" style="padding: 10px 22px;" id="checkAvailabilityBtn">
            Check Availability First
          </a>
        <?php endif; ?>
      </div>
    </div>

  </div>
</div>

<?php include '../includes/footer.php'; ?>
