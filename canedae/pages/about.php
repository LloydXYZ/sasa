<?php
// pages/about.php – About Us page
require_once '../config/db.php';
startSession();

$page_title = 'About Us';
include '../includes/header.php';
?>

<div class="about-page">
  <h1 class="about-hero-title">
    Delicious Moments, <span class="italic-white">Perfectly Catered</span>
  </h1>

  <p class="about-text" style="margin-top:24px;">
    Established in 2005, <u>CaneDae Thirdhome</u> Garden Catering is located at <u>Prk. Agoho</u>, Barangay Baclay,
    Tukuran, Zamboanga del Sur. Since its founding, the business has been providing catering services for
    different occasions, including weddings, birthdays, anniversaries, christenings, corporate events, family
    gatherings, and other special celebrations.
  </p>

  <p class="about-text">
    Over the years, <u>CaneDae Thirdhome</u> Garden Catering has earned the trust of many customers by
    offering delicious meals, affordable catering packages, and friendly, reliable service. We believe that every
    event is unique, so we work closely with our clients to ensure that their needs and expectations are met. At
    <u>CaneDae Thirdhome</u> Garden Catering, your special moments are our priority, and we are dedicated to
    making every event a successful and unforgettable celebration.
  </p>

  <div class="contact-section">
    <h3>CONTACT US AT:</h3>
    <div class="contact-item">
      <i class="fab fa-facebook-square" style="color:#1877f2;font-size:1.1rem;"></i>
      <strong>Facebook: CaneDae Third's Home Garden</strong>
    </div>
    <div class="contact-item">
      <i class="fa fa-phone" style="color:var(--dark-green);font-size:1rem;"></i>
      <strong>Phone Number: (+63) 9187305207</strong>
    </div>
  </div>

  <!-- Book Now button fixed bottom-right -->
  <div class="about-book-btn">
    <?php if(isLoggedIn()): ?>
      <a href="<?php echo BASE_URL; ?>pages/packages.php" class="btn-book-now">Book Now</a>
    <?php else: ?>
      <a href="<?php echo BASE_URL; ?>auth/login.php" class="btn-book-now">Book Now</a>
    <?php endif; ?>
  </div>
</div>

<?php include '../includes/footer.php'; ?>
