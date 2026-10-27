<?php
// pages/menu.php – Step 4: Menu Customization
// Flow: Package Details → THIS PAGE → Event Details
require_once '../config/db.php';
require_once '../includes/booking_flow.php';
startSession();
requireLogin();

// Arriving from Package Details: lock in the chosen package for this booking
if (isset($_GET['package_id'])) {
    $new_pkg = intval($_GET['package_id']);
    if (intval($_SESSION['booking']['package_id'] ?? 0) !== $new_pkg) {
        unset($_SESSION['booking']['menu_items']); // menu belongs to the previous package
    }
    $_SESSION['booking']['type']       = 'package';
    $_SESSION['booking']['package_id'] = $new_pkg;
    unset($_SESSION['booking']['tray_id']);
    redirect(BASE_URL . 'pages/menu.php'); // clean URL (PRG)
}

// Menu customization only applies to package bookings
if (($_SESSION['booking']['type'] ?? '') !== 'package') {
    redirect(BASE_URL . 'pages/packages.php');
}
requireBookingProgress(2); // date + package must be chosen

$page_title   = 'Menu Customization';
$current_step = 'menu';
$flow_type    = 'package';

$db = getDB();

// Fetch package info
$pkg_id = intval($_SESSION['booking']['package_id']);
$pkg    = $db->prepare("SELECT * FROM packages WHERE id = ? AND is_active = 1");
$pkg->execute([$pkg_id]);
$package = $pkg->fetch();

if(!$package) {
    unset($_SESSION['booking']['package_id']);
    redirect(BASE_URL . 'pages/packages.php');
}

// Fetch menu items for this package
$items_stmt = $db->prepare("SELECT * FROM menu_items WHERE package_id = ? AND is_active = 1 ORDER BY category, item_name");
$items_stmt->execute([$pkg_id]);
$all_items = $items_stmt->fetchAll();

// Group by category
$by_category = [];
foreach($all_items as $item) {
    $by_category[$item['category']][] = $item;
}
$valid_ids = array_map('intval', array_column($all_items, 'id'));

// Handle form submission
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Only keep items that actually belong to this package
    $selected_items = array_values(array_intersect(
        array_map('intval', $_POST['menu_items'] ?? []),
        $valid_ids
    ));
    if(empty($selected_items)) {
        $error = 'Please select at least one menu item.';
    } else {
        $_SESSION['booking']['menu_items'] = $selected_items;
        redirect(BASE_URL . 'pages/trays.php');
    }
}

$pre_selected_items = $_SESSION['booking']['menu_items'] ?? [];

include '../includes/header.php';
include '../includes/booking_steps.php';
?>

<div class="section-header">
  <h1 class="section-title" style="font-size:2rem;">🍽️ Menu Customization</h1>
  <p class="section-subtitle">
    Customizing menu for: <strong><?php echo htmlspecialchars($package['name']); ?></strong>
    &nbsp;·&nbsp; 📅 <?php echo date('F j, Y', strtotime($_SESSION['booking']['date'])); ?>
  </p>
</div>

<div class="menu-page">
  <?php if(isset($error)): ?>
    <div class="alert alert-error" style="max-width:900px;margin:0 auto 16px;"><?php echo htmlspecialchars($error); ?></div>
  <?php endif; ?>

  <form method="POST" id="menuForm">
    <div class="menu-container">

      <p style="color:var(--text-mid);margin-bottom:24px;font-size:0.9rem;">
        <i class="fa fa-info-circle" style="color:var(--gold);"></i>
        Select your preferred dishes from each category below.
        You can choose multiple items per category.
      </p>

      <?php if (empty($by_category)): ?>
        <p style="color:var(--text-mid);">No menu items are available for this package yet. Please contact us or choose another package.</p>
      <?php endif; ?>

      <?php foreach($by_category as $category => $items): ?>
        <div class="menu-category">
          <h3><?php echo htmlspecialchars($category); ?></h3>
          <div class="menu-items-grid">
            <?php foreach($items as $item): ?>
              <div>
                <input type="checkbox" class="menu-checkbox"
                       id="item-<?php echo $item['id']; ?>"
                       name="menu_items[]"
                       value="<?php echo $item['id']; ?>"
                       <?php echo in_array($item['id'], $pre_selected_items) ? 'checked' : ''; ?>>
                <label class="menu-label" for="item-<?php echo $item['id']; ?>">
                  <?php echo htmlspecialchars($item['item_name']); ?>
                </label>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endforeach; ?>

      <div style="margin-top:16px;padding:14px;background:var(--linen);border-radius:8px;font-size:0.85rem;">
        <strong style="color:var(--dark-green);">Selected:</strong>
        <span id="selectedCount">0</span> item(s) chosen.
      </div>
    </div>

    <div class="flow-actions" style="max-width:900px;margin:24px auto 0;">
      <a href="<?php echo BASE_URL; ?>pages/package-details.php?id=<?php echo $pkg_id; ?>" class="btn-flow-back">Package Details</a>
      <button type="submit" class="btn-flow-next" id="menuNextBtn">Continue to Food Trays</button>
    </div>
  </form>
</div>

<script>
function updateCount(){
  const checked = document.querySelectorAll('.menu-checkbox:checked').length;
  document.getElementById('selectedCount').textContent = checked;
}
document.querySelectorAll('.menu-checkbox').forEach(cb => cb.addEventListener('change', updateCount));
updateCount();
</script>

<?php include '../includes/footer.php'; ?>
