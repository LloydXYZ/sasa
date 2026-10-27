<?php
// pages/booking-choice.php – Step 2: Select Booking Type (after date & time are chosen)
require_once '../config/db.php';
require_once '../includes/booking_flow.php';
startSession();
requireLogin();
requireBookingProgress(1); // must have picked a date first

$page_title = 'Select Booking Type';
$chosen_date = $_SESSION['booking']['date'];
$chosen_time = $_SESSION['booking']['event_time'] ?? '';
$display_date = date('F j, Y (l)', strtotime($chosen_date));

$current_step = 'package';
include '../includes/header.php';
include '../includes/booking_steps.php';
?>

<style>
.choice-wrapper {
  max-width: 880px;
  margin: 36px auto 60px;
  padding: 0 20px;
}
.choice-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 28px;
  margin-top: 32px;
  margin-bottom: 40px;
}
@media (max-width: 680px) {
  .choice-grid { grid-template-columns: 1fr; }
}
.booking-choice-card {
  background: #ffffff;
  background-image: radial-gradient(circle, rgba(74, 55, 40, 0.08) 1px, transparent 1px);
  background-size: 20px 20px;
  border: 2px dashed #b8a88a;
  border-radius: 22px;
  padding: 42px 32px;
  text-align: center;
  text-decoration: none;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 16px;
  box-shadow: 0 6px 24px rgba(0,0,0,0.08);
  transition: all 0.2s ease;
  cursor: pointer;
}
.booking-choice-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 12px 32px rgba(43, 85, 28, 0.18);
  border-color: #4a7c2f;
}
.choice-icon-wrap {
  width: 90px;
  height: 90px;
  border-radius: 50%;
  background: #f7f1e6;
  border: 2px solid #dfd2be;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 3.2rem;
  box-shadow: 0 4px 12px rgba(0,0,0,0.06);
}
.choice-title {
  font-family: 'Playfair Display', serif;
  font-size: 1.6rem;
  font-weight: 700;
  color: #1a140e;
  margin-top: 6px;
}
.choice-desc {
  font-family: 'Lato', sans-serif;
  font-size: 0.96rem;
  color: #554433;
  line-height: 1.6;
  margin: 0;
  flex: 1;
}
.choice-btn {
  background: #2b551c;
  color: #ffffff;
  font-family: 'Lato', sans-serif;
  font-weight: 700;
  font-size: 1rem;
  padding: 11px 28px;
  border-radius: 24px;
  border: none;
  margin-top: 10px;
  transition: background 0.2s;
  display: inline-block;
}
.booking-choice-card:hover .choice-btn {
  background: #1c3812;
}
.btn-back-gold {
  background: linear-gradient(180deg, #f7d36b 0%, #ebbe42 100%);
  color: #2b1c06;
  border: 1.5px solid #82631a;
  border-radius: 6px;
  padding: 9px 24px;
  font-family: 'Lato', sans-serif;
  font-weight: 700;
  font-size: 0.95rem;
  text-decoration: none;
  display: inline-block;
  transition: all 0.15s;
}
.btn-back-gold:hover {
  background: #ebbe42;
  transform: translateY(-1px);
}
</style>

<div class="choice-wrapper">
  <!-- Heading -->
  <div style="margin-bottom: 24px;">
    <h1 style="font-family:'Playfair Display', serif; font-size: 2.4rem; font-weight: 700; color: #1a140e; margin-bottom: 6px;">
      How would you like to book?
    </h1>
    <div style="display:inline-flex; align-items:center; gap:8px; background:#fff; border:1px solid #d4c8b5; padding:6px 16px; border-radius:20px; font-family:'Lato', sans-serif; font-size:0.95rem; color:#3a2e22;">
      <span>📅 <strong><?php echo htmlspecialchars($display_date); ?></strong></span>
      <?php if($chosen_time): ?>
        <span>·</span>
        <span>⏰ <strong><?php echo htmlspecialchars(date('g:i A', strtotime($chosen_time))); ?></strong></span>
      <?php endif; ?>
    </div>
  </div>

  <!-- Choice Cards -->
  <div class="choice-grid">

    <!-- Option A: Package (with optional add-on Trays later) -->
    <a href="packages.php?booking=1" class="booking-choice-card" id="choicePackage">
      <div class="choice-icon-wrap">🎉</div>
      <div class="choice-title">Catering Package</div>
      <p class="choice-desc">
        Choose a complete all-in-one catering package with full buffet setup, staff, and menu customization. <strong>You can also add food trays to your package order!</strong>
      </p>
      <span class="choice-btn">Select Package</span>
    </a>

    <!-- Option B: Trays Only (Skip Package) -->
    <a href="trays.php?skip_package=1" class="booking-choice-card" id="choiceTrays">
      <div class="choice-icon-wrap">🍱</div>
      <div class="choice-title">Food Trays Only</div>
      <p class="choice-desc">
        Don't need a full catering package? Skip the package and pick only individual food party trays (Chicken, Beef, Seafood, Vegetables) for your event.
      </p>
      <span class="choice-btn">Order Trays Only</span>
    </a>

  </div>

  <!-- Back link -->
  <div>
    <a href="<?php echo BASE_URL; ?>pages/calendar.php" class="btn-back-gold">
      Back to Calendar
    </a>
  </div>
</div>

<?php include '../includes/footer.php'; ?>
