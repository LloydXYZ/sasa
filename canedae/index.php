<?php
// index.php – Homepage
require_once 'config/db.php';
startSession();

$page_title = 'Home';
include 'includes/header.php';
?>

<!-- ── HERO SECTION ── -->
<section class="hero">
  <div class="hero-content">
    <h1 class="hero-title">
      Delicious<br>
      Moments,<br>
      <span class="italic-white">Perfectly</span><br>
      <span class="italic-white">Catered</span>
    </h1>
    <p class="hero-subtitle">
      From intimate gatherings to grand celebrations,<br>
      we make every occasion unforgettable.
    </p>
    <?php if(isLoggedIn()): ?>
      <a href="pages/calendar.php" class="btn-book-now" id="heroBookNowBtn">Book Now</a>
    <?php else: ?>
      <a href="auth/login.php?redirect=calendar" class="btn-book-now" id="heroBookNowBtn">Book Now</a>
    <?php endif; ?>
  </div>

  <div class="hero-image">
    <div class="hero-img-stack">
      <div class="img-card">
        <img src="assets/images/hero_food.jpg" alt="Catering Setup"
             onerror="this.src='https://images.unsplash.com/photo-1555244162-803834f70033?w=500'">
      </div>
      <div class="img-card">
        <img src="assets/images/hero_food.jpg" alt="Catering Setup"
             onerror="this.src='https://images.unsplash.com/photo-1555244162-803834f70033?w=500'">
      </div>
      <div class="img-card">
        <img src="assets/images/hero_food.jpg" alt="Catering Setup"
             onerror="this.src='https://images.unsplash.com/photo-1555244162-803834f70033?w=500'">
      </div>
    </div>
  </div>
</section>

<!-- FOOTER -->
<footer class="hero-footer">
  &copy; 2026 CaneDae ThirdHome Garden Catering Service. All right reserved.
</footer>

<?php include 'includes/footer.php'; ?>
