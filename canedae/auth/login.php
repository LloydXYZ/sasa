<?php
// auth/login.php
require_once '../config/db.php';
startSession();

// Redirect if already logged in
if(isLoggedIn()) {
    redirect(BASE_URL . (isAdmin() ? 'admin/dashboard.php' : 'index.php'));
}

$error = '';
$redirect_to = $_GET['redirect'] ?? ($_POST['redirect'] ?? '');

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if(empty($email) || empty($password)) {
        $error = 'Please fill in all fields.';
    } else {
        $db   = getDB();
        $stmt = $db->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if($user && password_verify($password, $user['password']) && isset($user['is_active']) && !$user['is_active']) {
            $error = 'This account has been disabled. Please contact us.';
        } elseif($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id']   = $user['id'];
            $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];
            $_SESSION['role']      = $user['role'];
            $_SESSION['email']     = $user['email'];

            if($user['role'] === 'admin') {
                redirect(BASE_URL . 'admin/dashboard.php');
            } elseif ($redirect_to === 'calendar') {
                redirect(BASE_URL . 'pages/calendar.php');
            } else {
                redirect(BASE_URL . 'index.php');
            }
        } else {
            $error = 'Invalid email or password.';
        }
    }
}

$page_title = 'Login';
include '../includes/header.php';
?>

<div class="auth-page">
  <div class="auth-box">
    <div class="auth-logo">
      <img src="<?php echo BASE_URL; ?>assets/images/logo.png" alt="Logo"
           onerror="this.style.display='none'">
      <h1>CaneDae ThirdHome<br><span style="color:var(--gold);font-family:'Playfair Display',serif;font-style:italic;">Catering</span></h1>
    </div>

    <h2>Welcome Back</h2>
    <p class="auth-subtitle">Sign in to book your catering event</p>

    <?php if($error): ?>
      <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST" action="">
      <input type="hidden" name="redirect" value="<?php echo htmlspecialchars($redirect_to); ?>">
      <div class="form-group">
        <label for="email"><i class="fa fa-envelope"></i> Email Address</label>
        <input type="email" id="email" name="email" placeholder="you@example.com"
               value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
      </div>
      <div class="form-group">
        <label for="password"><i class="fa fa-lock"></i> Password</label>
        <input type="password" id="password" name="password" placeholder="••••••••" required>
      </div>
      <button type="submit" class="btn-submit">Login</button>
    </form>

    <p class="auth-link">
      Don't have an account? <a href="register.php">Register here</a>
    </p>

  </div>
</div>

<?php include '../includes/footer.php'; ?>
