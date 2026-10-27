<?php
// pages/trays.php – Step 4: Food Trays (Add-ons or Trays Only)
// Flow: Menu Customization (or Skip Package) → THIS PAGE → Event Details
require_once '../config/db.php';
require_once '../includes/booking_flow.php';
startSession();

// If coming via "Skip Package", clear any chosen package
if (isset($_GET['skip_package'])) {
    unset($_SESSION['booking']['package_id'], $_SESSION['booking']['menu_items']);
    $_SESSION['booking']['skip_package'] = 1;
}

$page_title = 'Our Food Trays';
$db         = getDB();
$trays      = $db->query("SELECT * FROM trays WHERE is_active = 1 ORDER BY id")->fetchAll();

$in_booking   = bookingInProgress();
$has_package  = !empty($_SESSION['booking']['package_id']);
$package_info = null;

if ($has_package) {
    $pkg_stmt = $db->prepare("SELECT * FROM packages WHERE id = ?");
    $pkg_stmt->execute([intval($_SESSION['booking']['package_id'])]);
    $package_info = $pkg_stmt->fetch() ?: null;
}

$pre_trays = bookingGetTrays();
$error     = '';

// Handle tray selection form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? 'save';

    if ($action === 'skip') {
        // Customer chose to skip food trays
        if (!$has_package) {
            $error = 'You skipped the package, so please select at least one food tray to proceed.';
        } else {
            $_SESSION['booking']['trays'] = [];
            redirect(BASE_URL . 'pages/event-details.php');
        }
    } else {
        $submitted_qtys = $_POST['tray_qty'] ?? [];
        $clean_trays = [];
        foreach ($submitted_qtys as $tid => $qty) {
            $tid = intval($tid);
            $qty = intval($qty);
            if ($tid > 0 && $qty > 0) {
                $clean_trays[$tid] = $qty;
            }
        }

        if (empty($clean_trays) && !$has_package) {
            $error = 'Please select at least one food tray, or go back to select a Catering Package.';
        } else {
            $_SESSION['booking']['trays'] = $clean_trays;
            redirect(BASE_URL . 'pages/event-details.php');
        }
    }
}

$current_step = 'trays';
include '../includes/header.php';
if ($in_booking) {
    include '../includes/booking_steps.php';
}
?>

<div class="page-container" style="max-width: 1060px;">
  <!-- Title matching mockup -->
  <div style="text-align: center; margin-bottom: 24px;">
    <h1 style="font-family:'Playfair Display', serif; font-size: 3rem; font-weight: 700; color: #ffffff; text-shadow: 2px 3px 6px rgba(0,0,0,0.3); letter-spacing: 1px; margin-bottom: 6px;">
      Our Food Trays Family
    </h1>
    <p style="font-family:'Playfair Display', serif; font-size: 1.15rem; color: #241910;">
      <?php if ($has_package): ?>
        Add extra food trays to your package, or skip this step to proceed with your package only.
      <?php else: ?>
        Choose the food trays you'd like to order for your event.
      <?php endif; ?>
    </p>
  </div>

  <?php if ($error): ?>
    <div class="alert alert-error" style="max-width: 900px; margin: 0 auto 20px;"><?php echo htmlspecialchars($error); ?></div>
  <?php endif; ?>

  <?php if ($in_booking): ?>
    <!-- Status Banner explaining the user's current order state -->
    <div style="background:#ffffff; border-radius:16px; padding:18px 24px; margin-bottom:28px; box-shadow:0 6px 20px rgba(0,0,0,0.08); border:1.5px solid #dcd5ca; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:14px;">
      <div style="display:flex; align-items:center; gap:14px;">
        <span style="font-size:2rem;"><?php echo $has_package ? '🎉' : '🍱'; ?></span>
        <div>
          <?php if ($has_package && $package_info): ?>
            <strong style="font-size:1.05rem; color:#1a140e;">Package Included: <?php echo htmlspecialchars($package_info['name']); ?></strong>
            <span style="color:#2e5c1e; font-weight:700; margin-left:8px;">(P <?php echo number_format($package_info['price_min'], 0); ?>)</span>
            <p style="margin:2px 0 0; font-size:0.9rem; color:#554433;">You can select add-on trays below, or click <em>"Skip Trays"</em> to proceed with the package only.</p>
          <?php else: ?>
            <strong style="font-size:1.05rem; color:#1a140e;">Food Trays Order (Package Skipped)</strong>
            <p style="margin:2px 0 0; font-size:0.9rem; color:#554433;">Select your desired quantity for each party tray below.</p>
          <?php endif; ?>
        </div>
      </div>
      <div>
        <?php if ($has_package): ?>
          <span style="font-size:0.85rem; background:#e8f4e5; color:#2d5016; padding:6px 14px; border-radius:20px; font-weight:700;">
            Trays are Optional
          </span>
        <?php else: ?>
          <a href="<?php echo BASE_URL; ?>pages/packages.php" style="font-size:0.85rem; color:#2a5da8; font-weight:700; text-decoration:underline;">
            Want a Package instead?
          </a>
        <?php endif; ?>
      </div>
    </div>
  <?php endif; ?>

  <form method="POST" id="traysForm">
    <!-- Cards Grid matching the mockup -->
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 24px; margin-bottom: 32px;">
      <?php foreach($trays as $tray): ?>
        <?php
          $tid       = $tray['id'];
          $cur_qty   = $pre_trays[$tid] ?? 0;
          $img_src   = BASE_URL . $tray['image'];
          $pax_label = ($tray['pax_min'] && $tray['pax_max']) ? 'Good for ' . $tray['pax_min'] . '-' . $tray['pax_max'] . ' pax' : 'Party size tray';
          $price_val = floatval($tray['price']);
          $price_fmt = ($price_val > 0) ? 'P ' . number_format($price_val, 2) : 'P ---';
        ?>
        <div class="design-card tray-item-card" data-tray-id="<?php echo $tid; ?>" data-price="<?php echo $price_val; ?>"
             style="padding: 18px; border-radius: 24px; display: flex; flex-direction: column; transition: transform 0.15s, border-color 0.15s; <?php echo $cur_qty > 0 ? 'border: 2px solid #2b551c; background: #fafdf8;' : ''; ?>">
          
          <div style="width: 100%; height: 170px; overflow: hidden; border-radius: 18px; margin-bottom: 12px;">
            <img src="<?php echo htmlspecialchars($img_src); ?>" 
                 alt="<?php echo htmlspecialchars($tray['name']); ?>"
                 style="width: 100%; height: 100%; object-fit: cover;"
                 onerror="this.src='https://images.unsplash.com/photo-1544025162-d76694265947?w=500'">
          </div>

          <div style="flex: 1; display: flex; flex-direction: column;">
            <div style="font-family:'Playfair Display', serif; font-size: 1.25rem; font-weight: 700; color: #1a140e; margin-bottom: 2px;">
              <?php echo htmlspecialchars($tray['name']); ?>
            </div>
            <div style="font-size: 0.85rem; color: #5a493a; margin-bottom: 8px;">
              <?php echo htmlspecialchars($pax_label); ?>
            </div>
            <div style="font-family:'Cinzel', serif; font-size: 1.3rem; font-weight: 700; color: #2e5c1e; margin-bottom: 14px;">
              <?php echo $price_fmt; ?>
            </div>

            <!-- Inclusions preview -->
            <div style="font-size: 0.8rem; color: #665544; margin-bottom: 14px; line-height: 1.4;">
              <?php
                $inc_text = trim($tray['inclusions'] ?? '');
                if ($inc_text) {
                    $inc_items = array_slice(array_filter(array_map('trim', explode("\n", $inc_text))), 0, 3);
                    echo htmlspecialchars(implode(', ', $inc_items)) . '...';
                } else {
                    echo 'Freshly prepared specialty tray.';
                }
              ?>
              <div>
                <a href="<?php echo BASE_URL; ?>pages/tray-details.php?id=<?php echo $tid; ?>" style="color:#2a5da8; text-decoration:underline; font-size:0.78rem;">View details</a>
              </div>
            </div>

            <!-- Quantity Selector Control -->
            <div style="margin-top: auto; padding-top: 10px; border-top: 1px dashed #d4c8b5;">
              <div style="display: flex; justify-content: space-between; align-items: center;">
                <label style="font-size: 0.88rem; font-weight: 700; color: #2b1f14;">Quantity:</label>
                <div style="display: inline-flex; align-items: center; border: 1.5px solid #2b551c; border-radius: 20px; overflow: hidden; background: #fff;">
                  <button type="button" class="btn-qty-minus" onclick="changeQty(<?php echo $tid; ?>, -1)"
                          style="background: #f4efe7; border: none; padding: 4px 12px; font-size: 1rem; font-weight: 700; cursor: pointer; color: #2b1f14;">–</button>
                  <input type="number" name="tray_qty[<?php echo $tid; ?>]" id="trayQty_<?php echo $tid; ?>"
                         value="<?php echo $cur_qty; ?>" min="0" max="50"
                         onchange="calcLiveTotals()"
                         style="width: 44px; text-align: center; border: none; font-weight: 700; font-size: 0.95rem; outline: none; background: transparent;">
                  <button type="button" class="btn-qty-plus" onclick="changeQty(<?php echo $tid; ?>, 1)"
                          style="background: #f4efe7; border: none; padding: 4px 12px; font-size: 1rem; font-weight: 700; cursor: pointer; color: #2b1f14;">+</button>
                </div>
              </div>
              <div id="subtotalDisplay_<?php echo $tid; ?>" style="text-align: right; font-size: 0.8rem; color: #2e5c1e; font-weight: 700; margin-top: 4px; min-height: 16px;">
                <?php if ($cur_qty > 0): ?>Subtotal: P <?php echo number_format($price_val * $cur_qty, 2); ?><?php endif; ?>
              </div>
            </div>

          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- Live Total Bar -->
    <div style="background: #ffffff; border-radius: 16px; padding: 20px 28px; box-shadow: 0 6px 24px rgba(0,0,0,0.08); border: 1.5px solid #d4c8b5; margin-bottom: 30px;">
      <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
        <div>
          <div style="font-family:'Cinzel', serif; font-size: 1.25rem; font-weight: 700; color: #1a140e;">
            Order Selection
          </div>
          <div style="font-size: 0.92rem; color: #554433; margin-top: 4px;" id="orderSelectionSummary">
            Calculating...
          </div>
        </div>
        <div style="text-align: right;">
          <div style="font-size: 0.85rem; color: #665544;">Total Amount:</div>
          <div style="font-family:'Cinzel', serif; font-size: 1.8rem; font-weight: 800; color: #2e5c1e;" id="grandTotalDisplay">
            P 0.00
          </div>
          <div style="font-size: 0.82rem; color: #2a5da8; font-weight: 600;" id="downpaymentNoticeDisplay">
            30% Downpayment: P 0.00
          </div>
        </div>
      </div>
    </div>

    <!-- Bottom Actions -->
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
      <?php
        $back_href = $has_package
            ? BASE_URL . 'pages/menu.php'
            : BASE_URL . 'pages/packages.php';
        $back_label = $has_package ? 'Back to Menu' : 'Back to Packages';
      ?>
      <a href="<?php echo $back_href; ?>" class="btn-flow-back">
        <?php echo $back_label; ?>
      </a>

      <div style="display: flex; gap: 12px; flex-wrap: wrap;">
        <?php if ($has_package): ?>
          <button type="submit" name="action" value="skip" class="btn-silver-pill" style="padding: 11px 22px; font-weight: 700;">
            Skip Trays (Package Only)
          </button>
        <?php endif; ?>
        <button type="submit" name="action" value="save" class="btn-flow-next" id="saveTraysBtn">
          Continue to Event Details
        </button>
      </div>
    </div>
  </form>
</div>

<script>
const packagePrice = <?php echo floatval($package_info['price_min'] ?? 0); ?>;
const packageName  = "<?php echo addslashes($package_info['name'] ?? ''); ?>";
const hasPackage   = <?php echo $has_package ? 'true' : 'false'; ?>;

function changeQty(trayId, delta) {
  const input = document.getElementById('trayQty_' + trayId);
  let val = parseInt(input.value) || 0;
  val = Math.max(0, Math.min(50, val + delta));
  input.value = val;
  calcLiveTotals();
}

function calcLiveTotals() {
  let totalTraysCount = 0;
  let traysSubtotal   = 0;

  document.querySelectorAll('.tray-item-card').forEach(card => {
    const tid   = card.getAttribute('data-tray-id');
    const price = parseFloat(card.getAttribute('data-price')) || 0;
    const input = document.getElementById('trayQty_' + tid);
    const qty   = parseInt(input.value) || 0;
    const subdisp = document.getElementById('subtotalDisplay_' + tid);

    if (qty > 0) {
      card.style.borderColor = '#2b551c';
      card.style.background  = '#fafdf8';
      subdisp.textContent   = 'Subtotal: P ' + (price * qty).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
      totalTraysCount += qty;
      traysSubtotal   += (price * qty);
    } else {
      card.style.borderColor = 'rgba(0,0,0,0.05)';
      card.style.background  = '#ffffff';
      subdisp.textContent   = '';
    }
  });

  const grandTotal  = (hasPackage ? packagePrice : 0) + traysSubtotal;
  const downpayment = grandTotal * 0.30;

  let summaryParts = [];
  if (hasPackage && packageName) {
    summaryParts.push('<strong>' + packageName + '</strong> (P ' + packagePrice.toLocaleString(undefined, {minimumFractionDigits: 2}) + ')');
  }
  if (totalTraysCount > 0) {
    summaryParts.push('<strong>' + totalTraysCount + ' Food Tray(s)</strong> (P ' + traysSubtotal.toLocaleString(undefined, {minimumFractionDigits: 2}) + ')');
  } else if (!hasPackage) {
    summaryParts.push('<span style="color:#c00;">No trays selected yet. Please select at least 1 tray.</span>');
  } else {
    summaryParts.push('No extra trays selected (Package only)');
  }

  document.getElementById('orderSelectionSummary').innerHTML = summaryParts.join(' &nbsp;+&nbsp; ');
  document.getElementById('grandTotalDisplay').textContent = 'P ' + grandTotal.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
  document.getElementById('downpaymentNoticeDisplay').textContent = '30% Downpayment Due: P ' + downpayment.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
}

// Initial calculation on load
calcLiveTotals();
</script>

<?php include '../includes/footer.php'; ?>
