<?php
// pages/packages.php – Catering Packages Listing
require_once '../config/db.php';
require_once '../includes/booking_flow.php';
startSession();

$page_title = 'Our Catering Packages';
$db = getDB();
$packages = $db->query("SELECT * FROM packages WHERE is_active = 1 ORDER BY id")->fetchAll();

$in_booking = bookingInProgress();

include '../includes/header.php';
if ($in_booking) {
    $current_step = 'package';
    include '../includes/booking_steps.php';
}
?>

<div class="page-container" style="max-width: 1040px;">
  <!-- Styled white serif title matching mockup style -->
  <div style="text-align: center; margin-bottom: 24px;">
    <h1 style="font-family:'Playfair Display', serif; font-size: 3rem; font-weight: 700; color: #ffffff; text-shadow: 2px 3px 6px rgba(0,0,0,0.3); letter-spacing: 1px; margin-bottom: 6px;">
      Our Catering Packages
    </h1>
    <p style="font-family:'Playfair Display', serif; font-size: 1.15rem; color: #241910;">
      Choose the perfect package for your special event.
    </p>
  </div>

  <?php if ($in_booking): ?>
    <!-- Notice: customer can skip package and order trays only -->
    <div style="background:#ffffff; border:1.5px dashed #4a7c2f; border-radius:14px; padding:16px 22px; margin-bottom:28px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; box-shadow:0 4px 14px rgba(0,0,0,0.06);">
      <div style="display:flex; align-items:center; gap:12px;">
        <span style="font-size:1.8rem;">🍱</span>
        <div>
          <strong style="color:#1a140e; font-size:1.02rem;">Don't need a full catering package?</strong>
          <p style="margin:0; font-size:0.9rem; color:#554433;">You can skip this step and order party food trays only, or select a package now and add food trays later!</p>
        </div>
      </div>
      <a href="<?php echo BASE_URL; ?>pages/trays.php?skip_package=1" class="btn-silver-pill" style="padding:9px 20px; font-weight:700; color:#2b551c; border-color:#2b551c; white-space:nowrap;">
        Skip Package &amp; Order Trays Only
      </a>
    </div>
  <?php endif; ?>

  <!-- Cards Grid -->
  <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 24px; margin-bottom: 40px;">
    <?php foreach($packages as $pkg): ?>
      <?php
        $img_src = BASE_URL . $pkg['image'];
        $pax_label = ($pkg['pax_min'] === $pkg['pax_max'])
            ? 'Good for ' . $pkg['pax_min'] . ' pax'
            : 'Good for ' . $pkg['pax_min'] . '-' . $pkg['pax_max'] . ' pax';
        $price_label = ($pkg['price_min'] === $pkg['price_max'])
            ? 'P ' . number_format($pkg['price_min'], 0)
            : 'P ' . number_format($pkg['price_min'], 0) . ' - ' . number_format($pkg['price_max'], 0);
      ?>
      <div class="design-card" style="padding: 16px; border-radius: 24px; display: flex; flex-direction: column;">
        <div style="width: 100%; height: 180px; overflow: hidden; border-radius: 18px; margin-bottom: 14px;">
          <img src="<?php echo htmlspecialchars($img_src); ?>" 
               alt="<?php echo htmlspecialchars($pkg['name']); ?>"
               style="width: 100%; height: 100%; object-fit: cover;"
               onerror="this.src='https://images.unsplash.com/photo-1555244162-803834f70033?w=500'">
        </div>
        <div style="flex: 1; display: flex; flex-direction: column;">
          <div style="font-family:'Playfair Display', serif; font-size: 1.25rem; font-weight: 700; color: #1a140e; margin-bottom: 3px;">
            <?php echo htmlspecialchars($pkg['name']); ?>
          </div>
          <div style="font-size: 0.85rem; color: #5a493a; margin-bottom: 12px;">
            <?php echo htmlspecialchars($pax_label); ?>
          </div>
          <div style="font-family:'Cinzel', serif; font-size: 1.35rem; font-weight: 700; color: #2e5c1e; margin-bottom: 16px;">
            <?php echo $price_label; ?>
          </div>
          <div style="margin-top: auto;">
            <a href="package-details.php?id=<?php echo $pkg['id']; ?>" class="btn-silver-pill" style="width: 100%; display: block; box-sizing: border-box;">
              View Details
            </a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <!-- Bottom Navigation -->
  <div style="margin-top: 20px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:14px;">
    <?php
      $back_href = $in_booking
          ? BASE_URL . 'pages/booking-choice.php'
          : BASE_URL . 'index.php';
    ?>
    <a href="<?php echo $back_href; ?>" class="btn-gold" style="padding: 8px 30px;">
      Back
    </a>
    <?php if ($in_booking): ?>
      <a href="<?php echo BASE_URL; ?>pages/trays.php?skip_package=1" class="btn-forest" style="padding: 9px 24px;">
        Skip Package (Order Trays Only)
      </a>
    <?php endif; ?>
  </div>
</div>

<?php include '../includes/footer.php'; ?>
