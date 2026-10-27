<?php
// includes/header.php
// Shared header: navbar for all pages
// Usage: include at the top of every page AFTER session start + db include

$current_page = basename($_SERVER['PHP_SELF'], '.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo isset($page_title) ? $page_title . ' – CaneDae ThirdHome Catering' : 'CaneDae ThirdHome Catering'; ?></title>
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/texture_fallback.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <?php if(isset($extra_css)): foreach($extra_css as $css): ?>
  <link rel="stylesheet" href="<?php echo BASE_URL . $css; ?>?v=<?php echo time(); ?>">
  <?php endforeach; endif; ?>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
  <!-- Brand -->
  <a class="navbar-brand" href="<?php echo BASE_URL; ?>">
    <img src="<?php echo BASE_URL; ?>assets/images/logo.png" alt="CaneDae Logo" onerror="this.style.display='none'">
    <span class="brand-text">CaneDae <em>ThirdHome</em> <span class="catering">Catering</span></span>
  </a>

  <?php if(isLoggedIn() && !isAdmin()): ?>
  <!-- LOGGED-IN CUSTOMER NAV -->
  <ul class="navbar-nav">
    <li><a href="<?php echo BASE_URL; ?>index.php" class="<?php echo ($current_page === 'index') ? 'active' : ''; ?>">Home</a></li>
    <li><a href="<?php echo BASE_URL; ?>pages/packages.php" class="<?php echo in_array($current_page, ['packages', 'package-details']) ? 'active' : ''; ?>">Packages</a></li>
    <li><a href="<?php echo BASE_URL; ?>pages/trays.php" class="<?php echo in_array($current_page, ['trays', 'tray-details']) ? 'active' : ''; ?>">Food Trays</a></li>
    <li><a href="<?php echo BASE_URL; ?>pages/my-reservations.php" class="<?php echo in_array($current_page, ['my-reservations', 'reservation-status', 'receipt']) ? 'active' : ''; ?>">My Reservations</a></li>
  </ul>
  <div class="navbar-actions">
    <a href="<?php echo BASE_URL; ?>pages/calendar.php" class="btn-book-nav">Book Now</a>
    <a href="<?php echo BASE_URL; ?>pages/account-settings.php" class="user-icon <?php echo ($current_page === 'account-settings') ? 'active' : ''; ?>" title="Account Settings">
      <i class="fa fa-user"></i>
    </a>
    <a href="<?php echo BASE_URL; ?>auth/logout.php" class="btn-logout">Logout</a>
  </div>

  <?php elseif(isAdmin()): ?>
  <!-- ADMIN NAV (matching Admin Dashboard reference tabs) -->
  <ul class="navbar-nav">
    <li><a href="<?php echo BASE_URL; ?>admin/dashboard.php" class="<?php echo ($current_page === 'dashboard') ? 'active' : ''; ?>">Dashboard</a></li>
    <li><a href="<?php echo BASE_URL; ?>admin/reservations.php" class="<?php echo ($current_page === 'reservations') ? 'active' : ''; ?>">Reservations</a></li>
    <li><a href="<?php echo BASE_URL; ?>admin/menu.php" class="<?php echo ($current_page === 'menu') ? 'active' : ''; ?>">Menu</a></li>
    <li><a href="<?php echo BASE_URL; ?>admin/packages.php" class="<?php echo in_array($current_page, ['packages', 'package-details']) ? 'active' : ''; ?>">Packages</a></li>
    <li><a href="<?php echo BASE_URL; ?>admin/trays.php" class="<?php echo in_array($current_page, ['trays', 'tray-details']) ? 'active' : ''; ?>">Trays</a></li>
  </ul>
  <div class="navbar-actions">
    <a href="<?php echo BASE_URL; ?>auth/logout.php" class="btn-logout">Logout</a>
  </div>

  <?php else: ?>
  <!-- GUEST NAV -->
  <div class="navbar-guest-group">
    <ul class="navbar-nav">
      <li><a href="<?php echo BASE_URL; ?>index.php" class="<?php echo ($current_page==='index')?'active':''; ?>">Home</a></li>
      <li><a href="<?php echo BASE_URL; ?>pages/packages.php" class="<?php echo in_array($current_page, ['packages', 'package-details']) ? 'active' : ''; ?>">Packages</a></li>
      <li><a href="<?php echo BASE_URL; ?>pages/trays.php" class="<?php echo in_array($current_page, ['trays', 'tray-details']) ? 'active' : ''; ?>">Food Trays</a></li>
      <li><a href="<?php echo BASE_URL; ?>pages/about.php" class="<?php echo ($current_page==='about')?'active':''; ?>">About Us</a></li>
    </ul>
    <div class="navbar-actions">
      <a href="<?php echo BASE_URL; ?>auth/login.php?redirect=calendar" class="btn-book-nav">Book Now</a>
      <a href="<?php echo BASE_URL; ?>auth/login.php" class="btn-login">Login</a>
      <a href="<?php echo BASE_URL; ?>auth/register.php" class="btn-register">Register</a>
    </div>
  </div>
  <?php endif; ?>
</nav>

<?php
// Flash message display
startSession();
if(isset($_SESSION['flash'])):
  $flash = $_SESSION['flash'];
  unset($_SESSION['flash']);
?>
<div class="alert alert-<?php echo htmlspecialchars($flash['type']); ?>" style="margin:12px 40px 0;">
  <?php echo htmlspecialchars($flash['message']); ?>
</div>
<?php endif; ?>
