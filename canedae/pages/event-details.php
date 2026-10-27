<?php
// pages/event-details.php – Step 5: Event Details
// Flow: Food Trays → THIS PAGE → Reservation Summary
require_once '../config/db.php';
require_once '../includes/booking_flow.php';
startSession();
requireLogin();
requireBookingProgress(3); // must have date and at least a package or trays

$page_title   = 'Event Details';
$current_step = 'details';
$db           = getDB();
$pre          = $_SESSION['booking'];

$totals         = bookingCalculateTotals($db);
$selected_pkg   = $totals['package'];
$selected_trays = $totals['trays'];

// Pax constraints
$pax_max     = $selected_pkg ? intval($selected_pkg['pax_max']) : 0;
$pax_default = $selected_pkg ? intval($selected_pkg['pax_max']) : '';

// Event types (pre-select from package name, e.g. "Birthday Package" → Birthday)
$event_types = ['Birthday', 'Anniversary', 'Debut', 'Wedding', 'Corporate', 'Christening', 'Reunion', 'Other'];
$default_event_type = 'Birthday';
if ($selected_pkg) {
    foreach ($event_types as $et) {
        if (stripos($selected_pkg['name'], $et) !== false) { $default_event_type = $et; break; }
    }
}

// Fetch user for pre-fill
$user_stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
$user_stmt->execute([$_SESSION['user_id']]);
$user = $user_stmt->fetch();
$user_full_name = trim(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? ''));

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event_name  = trim($_POST['event_name'] ?? '');
    $full_name   = trim($_POST['full_name'] ?? '');
    $contact_no  = trim($_POST['contact_number'] ?? '');
    $email       = trim($_POST['email'] ?? '');
    $event_time  = trim($_POST['event_time'] ?? '');
    $event_venue = trim($_POST['event_venue'] ?? '');
    $event_type  = trim($_POST['event_type'] ?? '');
    $special     = trim($_POST['special'] ?? '');
    $pax_input   = trim($_POST['pax'] ?? '');

    // Pax: optional – defaults to package pax_max when left blank
    if ($pax_input === '') {
        $pax = $selected_pkg ? $pax_max : 0;
    } else {
        $pax = intval($pax_input);
    }

    if ($event_name === '' || $full_name === '' || $contact_no === '' || $email === '' || $event_time === '' || $event_venue === '') {
        $error = 'Please fill in all required fields (marked with *).';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } elseif ($pax_input !== '' && $pax < 1) {
        $error = 'Number of guests must be at least 1.';
    } elseif ($selected_pkg && $pax > $pax_max) {
        $error = 'The number of guests cannot exceed ' . $pax_max . ' for the ' . $selected_pkg['name'] . '.';
    } else {
        $_SESSION['booking']['event_name']     = $event_name;
        $_SESSION['booking']['full_name']      = $full_name;
        $_SESSION['booking']['contact_number'] = $contact_no;
        $_SESSION['booking']['email']          = $email;
        $_SESSION['booking']['event_time']     = $event_time;
        $_SESSION['booking']['event_venue']    = $event_venue;
        $_SESSION['booking']['event_type']     = in_array($event_type, $event_types) ? $event_type : 'Other';
        $_SESSION['booking']['special']        = $special;
        $_SESSION['booking']['pax']            = $pax;

        redirect(BASE_URL . 'pages/summary.php');
    }

    // Re-populate the form with what was submitted
    $pre = array_merge($pre, [
        'event_name' => $event_name, 'full_name' => $full_name, 'contact_number' => $contact_no,
        'email' => $email, 'event_time' => $event_time, 'event_venue' => $event_venue,
        'event_type' => $event_type, 'special' => $special, 'pax' => $pax_input,
    ]);
}

include '../includes/header.php';
include '../includes/booking_steps.php';
?>

<style>
.event-res-wrap {
  max-width: 1060px;
  margin: 32px auto 60px;
  padding: 0 20px;
}
.event-res-layout {
  display: grid;
  grid-template-columns: 1.45fr 1fr;
  gap: 32px;
  align-items: start;
}
@media (max-width: 820px) {
  .event-res-layout { grid-template-columns: 1fr; }
}
.res-white-card {
  background: #ffffff;
  background-image: radial-gradient(circle, rgba(74, 55, 40, 0.10) 1.2px, transparent 1.2px);
  background-size: 22px 22px;
  border-radius: 20px;
  box-shadow: 0 6px 24px rgba(0,0,0,0.08);
  border: 1px solid rgba(0,0,0,0.05);
  padding: 32px 36px;
}
.res-fields-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 16px 20px;
  margin-bottom: 24px;
}
.res-fields-grid .span-2 { grid-column: 1 / -1; }
@media (max-width: 580px) {
  .res-fields-grid { grid-template-columns: 1fr; }
}
.res-field-label {
  display: block;
  font-family: 'Lato', sans-serif;
  font-weight: 700;
  font-size: 0.92rem;
  color: #1a140e;
  margin-bottom: 6px;
}
.res-field-input {
  width: 100%;
  padding: 10px 14px;
  border: 1.5px solid #4a3e30;
  border-radius: 6px;
  background: #ffffff;
  font-family: 'Lato', sans-serif;
  font-size: 0.95rem;
  color: #1a140e;
  outline: none;
  transition: all 0.15s;
  box-sizing: border-box;
}
.res-field-input:focus {
  border-color: #2b551c;
  box-shadow: 0 0 0 3px rgba(43,85,28,0.15);
}
.res-field-input:read-only {
  background: #f4efe7;
  cursor: default;
}
textarea.res-field-input { resize: vertical; min-height: 80px; }
.preview-card-wrap {
  background: #ffffff;
  background-image: radial-gradient(circle, rgba(74, 55, 40, 0.10) 1.2px, transparent 1.2px);
  background-size: 22px 22px;
  border-radius: 20px;
  box-shadow: 0 6px 24px rgba(0,0,0,0.08);
  border: 1px solid rgba(0,0,0,0.05);
  padding: 24px;
  display: flex;
  flex-direction: column;
}
.preview-card-img {
  width: 100%;
  height: 200px;
  border-radius: 14px;
  object-fit: cover;
  box-shadow: 0 3px 12px rgba(0,0,0,0.12);
  margin-bottom: 16px;
}
.preview-title {
  font-family: 'Cinzel', serif;
  font-size: 1.35rem;
  font-weight: 700;
  color: #1a140e;
  margin-bottom: 4px;
}
.preview-price {
  font-family: 'Cinzel', serif;
  font-size: 1.6rem;
  font-weight: 800;
  color: #2b551c;
  margin-bottom: 8px;
}
.preview-dashed-line {
  border-bottom: 1px dashed #7a6e60;
  margin: 12px 0;
}
</style>

<div class="event-res-wrap">
  <div style="margin-bottom: 24px;">
    <h1 style="font-family:'Playfair Display', serif; font-size: 2.4rem; font-weight: 700; color: #1a140e; margin-bottom: 4px;">
      Event Details
    </h1>
    <p style="font-family:'Playfair Display', serif; font-size: 1.05rem; color: #3a2e22;">
      Fill in the event information below to finalize your catering reservation
    </p>
  </div>

  <?php if ($error): ?>
    <div style="background:#fee2e2; border:1px solid #ef4444; color:#991b1b; padding:12px 18px; border-radius:8px; margin-bottom:20px; font-weight:600;">
      <?php echo htmlspecialchars($error); ?>
    </div>
  <?php endif; ?>

  <form method="POST" id="reservationForm">
    <div class="event-res-layout">

      <!-- Left Card: Form Inputs -->
      <div class="res-white-card">
        <div class="res-fields-grid">

          <div>
            <label class="res-field-label" for="eventName">Event Name: *</label>
            <input type="text" name="event_name" id="eventName" class="res-field-input"
                   value="<?php echo htmlspecialchars($pre['event_name'] ?? ''); ?>" required placeholder="e.g. Maria's Birthday">
          </div>

          <div>
            <label class="res-field-label" for="eventType">Event Type:</label>
            <select name="event_type" id="eventType" class="res-field-input" style="cursor:pointer;">
              <?php $cur_type = $pre['event_type'] ?? $default_event_type; ?>
              <?php foreach ($event_types as $et): ?>
                <option value="<?php echo $et; ?>" <?php echo $cur_type === $et ? 'selected' : ''; ?>><?php echo $et; ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div>
            <label class="res-field-label">Event Date:</label>
            <input type="text" class="res-field-input"
                   value="<?php echo htmlspecialchars(date('F j, Y', strtotime($pre['date']))); ?>" readonly>
          </div>

          <div>
            <label class="res-field-label" for="eventTime">Event Time: *</label>
            <input type="time" name="event_time" id="eventTime" class="res-field-input"
                   value="<?php echo htmlspecialchars($pre['event_time'] ?? '08:30'); ?>" required>
          </div>

          <div class="span-2">
            <label class="res-field-label" for="eventVenue">Event Venue / Address: *</label>
            <input type="text" name="event_venue" id="eventVenue" class="res-field-input"
                   value="<?php echo htmlspecialchars($pre['event_venue'] ?? ''); ?>" required
                   placeholder="e.g. Clubhouse, 123 Rizal St., City">
          </div>

          <div>
            <label class="res-field-label" for="fullName">Full Name: *</label>
            <input type="text" name="full_name" id="fullName" class="res-field-input"
                   value="<?php echo htmlspecialchars($pre['full_name'] ?? $user_full_name); ?>" required>
          </div>

          <div>
            <label class="res-field-label" for="contactNumber">Contact Number: *</label>
            <input type="tel" name="contact_number" id="contactNumber" class="res-field-input"
                   value="<?php echo htmlspecialchars($pre['contact_number'] ?? ($user['phone'] ?? '')); ?>" required>
          </div>

          <div>
            <label class="res-field-label" for="emailAddress">Email Address: *</label>
            <input type="email" name="email" id="emailAddress" class="res-field-input"
                   value="<?php echo htmlspecialchars($pre['email'] ?? ($user['email'] ?? '')); ?>" required>
          </div>

          <div>
            <label class="res-field-label" for="paxInput">
              Number of Guest:
              <?php if ($selected_pkg): ?>
                <small style="color:#2e5c1e; font-weight:600;">(max <?php echo $pax_max; ?>)</small>
              <?php else: ?>
                <small style="color:#888; font-weight:400;">(recommended based on trays)</small>
              <?php endif; ?>
            </label>
            <input type="number" name="pax" id="paxInput" class="res-field-input"
                   value="<?php $pax_val = $pre['pax'] ?? $pax_default; echo htmlspecialchars((string)($pax_val ?: '')); ?>"
                   min="1"
                   <?php if($pax_max > 0) echo 'max="' . $pax_max . '"'; ?>
                   placeholder="<?php echo $selected_pkg ? 'Leave blank = max (' . $pax_max . ')' : 'e.g. 50'; ?>">
          </div>

          <div class="span-2">
            <label class="res-field-label" for="specialRequests">Special Requests: <small style="color:#888; font-weight:400;">(optional)</small></label>
            <textarea name="special" id="specialRequests" class="res-field-input"
                      placeholder="Allergies, preferred setup, instructions, etc."><?php echo htmlspecialchars($pre['special'] ?? ''); ?></textarea>
          </div>

        </div>

        <div class="flow-actions" style="margin-top: 6px;">
          <a href="<?php echo BASE_URL; ?>pages/trays.php" class="btn-flow-back">Back to Food Trays</a>
          <button type="submit" class="btn-flow-next" id="reviewReservationBtn">
            Review Reservation
          </button>
        </div>
      </div>

      <!-- Right Card: Order Summary Preview (Package and/or Trays) -->
      <div class="preview-card-wrap">
        <?php if ($selected_pkg): ?>
          <img src="<?php echo BASE_URL . ($selected_pkg['image'] ?: 'assets/images/pkg_birthday.jpg'); ?>"
               alt="<?php echo htmlspecialchars($selected_pkg['name']); ?>" class="preview-card-img"
               onerror="this.src='https://images.unsplash.com/photo-1555244162-803834f70033?w=500'">
          <div style="font-size:0.85rem; color:#665544; font-weight:700;">PACKAGE:</div>
          <h3 class="preview-title"><?php echo htmlspecialchars($selected_pkg['name']); ?></h3>
          <div style="font-size:0.9rem; color:#5a4938; margin-bottom:4px;">Good for <?php echo $selected_pkg['pax_max']; ?> pax</div>
          <div style="font-weight:700; color:#2b551c; margin-bottom:12px;">P <?php echo number_format($totals['package_price'], 2); ?></div>
        <?php elseif (!empty($selected_trays)): ?>
          <img src="<?php echo BASE_URL . ($selected_trays[0]['tray']['image'] ?: 'assets/images/tray_chicken.jpg'); ?>"
               alt="Food Trays" class="preview-card-img"
               onerror="this.src='https://images.unsplash.com/photo-1544025162-d76694265947?w=500'">
          <div style="font-size:0.85rem; color:#665544; font-weight:700;">ORDER TYPE:</div>
          <h3 class="preview-title">Party Food Trays</h3>
        <?php endif; ?>

        <?php if (!empty($selected_trays)): ?>
          <div class="preview-dashed-line"></div>
          <div style="font-weight:700; font-size:0.92rem; color:#1a140e; margin-bottom:8px;">
            <?php echo $selected_pkg ? '🍱 Add-on Food Trays:' : '🍱 Selected Food Trays:'; ?>
          </div>
          <div style="display:flex; flex-direction:column; gap:6px; font-size:0.88rem;">
            <?php foreach ($selected_trays as $titem): ?>
              <div style="display:flex; justify-content:space-between;">
                <span><?php echo htmlspecialchars($titem['tray']['name']); ?> &times; <?php echo $titem['quantity']; ?></span>
                <strong>P <?php echo number_format($titem['subtotal'], 2); ?></strong>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

        <div class="preview-dashed-line"></div>

        <div style="display:flex; justify-content:space-between; align-items:baseline;">
          <strong style="font-size:1.05rem;">Estimated Total:</strong>
          <span class="preview-price" style="margin:0;">P <?php echo number_format($totals['grand_total'], 2); ?></span>
        </div>
        <div style="font-size:0.85rem; color:#2a5da8; text-align:right; font-weight:600; margin-top:4px;">
          30% Downpayment: P <?php echo number_format($totals['downpayment'], 2); ?>
        </div>

        <div style="margin-top:16px; display:flex; justify-content:space-between; font-size:0.85rem;">
          <?php if ($selected_pkg): ?>
            <a href="<?php echo BASE_URL; ?>pages/packages.php" class="flow-edit-link">Change Package</a>
          <?php endif; ?>
          <a href="<?php echo BASE_URL; ?>pages/trays.php" class="flow-edit-link">
            <?php echo !empty($selected_trays) ? 'Edit Trays' : '+ Add Food Trays'; ?>
          </a>
        </div>
      </div>

    </div>
  </form>
</div>

<?php include '../includes/footer.php'; ?>
