<?php
// Expects: $page_title, $admin_page (set before including)
$nav = [
  'dashboard' => ['Dashboard', 'dashboard.php', true],
  'reservations' => ['Reservations', 'reservations.php', true],
  'payments' => ['Payments', 'payments.php', true],
  'packages' => ['Packages', 'packages.php', true],
  'menu' => ['Menu items', 'menu.php', true],
  'trays' => ['Food trays', 'trays.php', true],
  'calendar' => ['Calendar', 'calendar.php', true],
  'users' => ['Customers', 'users.php', true],
  'reports' => ['Reports', 'reports.php', true],
  'settings' => ['Payment settings', 'settings.php', true],
  'terms' => ['Terms & Conditions', 'terms.php', true],
];
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo e($page_title ?? 'Admin'); ?> | CaneDae Admin</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700&family=Lato:wght@400;700&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>admin/assets/css/admin.css">
</head>

<body>
  <div class="shell">
    <aside class="sidebar">
      <div class="brand">CaneDae<small>ThirdHome Catering</small></div>
      <nav>
        <?php foreach ($nav as $key => [$label, $file, $ready]): ?>
          <?php if ($ready): ?>
            <a href="<?php echo BASE_URL . 'admin/' . $file; ?>"
              class="<?php echo ($admin_page ?? '') === $key ? 'active' : ''; ?>"><?php echo e($label); ?></a>
          <?php else: ?>
            <span class="soon" title="Not built yet"><?php echo e($label); ?></span>
          <?php endif; ?>
        <?php endforeach; ?>
      </nav>
      <div class="side-foot">
        <div><?php echo e($_SESSION['user_name'] ?? 'Admin'); ?></div>
        <a href="<?php echo BASE_URL; ?>admin/change-password.php">Change password</a>
        <a href="<?php echo BASE_URL; ?>index.php">View website</a>
        <a href="<?php echo BASE_URL; ?>auth/logout.php">Log out</a>
      </div>
    </aside>
    <main class="content">
      <h1><?php echo e($page_title ?? ''); ?></h1>