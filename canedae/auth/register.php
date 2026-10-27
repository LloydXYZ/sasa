<?php
// auth/register.php
require_once '../config/db.php';
startSession();

if(isLoggedIn()) redirect(BASE_URL . 'index.php');

$error   = '';
$success = '';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name  = trim($_POST['last_name']  ?? '');
    $email      = trim($_POST['email']      ?? '');
    $phone      = trim($_POST['phone']      ?? '');
    $password   = $_POST['password']  ?? '';
    $confirm    = $_POST['confirm_pw'] ?? '';

    // Validation
    if(empty($first_name) || empty($last_name) || empty($email) || empty($password)) {
        $error = 'Please fill in all required fields.';
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } elseif(strlen($password) < 8) {
        $error = 'Password must be at least 8 characters long.';
    } elseif($password !== $confirm) {
        $error = 'Passwords do not match.';
    } elseif(empty($_POST['agree_terms'])) {
        $error = 'Please agree to the Terms and Conditions to continue.';
    } else {
        $db = getDB();

        // Check duplicate email
        $stmt = $db->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        if($stmt->fetch()) {
            $error = 'An account with this email already exists.';
        } else {
            $hashed = password_hash($password, PASSWORD_BCRYPT);
            $ins = $db->prepare("INSERT INTO users (first_name, last_name, email, phone, password, role) VALUES (?,?,?,?,?,'user')");
            $ins->execute([$first_name, $last_name, $email, $phone, $hashed]);

            $_SESSION['flash'] = ['type' => 'success', 'message' => 'Account created! You can now log in.'];
            redirect(BASE_URL . 'auth/login.php');
        }
    }
}

$page_title = 'Register';
include '../includes/header.php';
?>

<div class="auth-page">
  <div class="auth-box" style="max-width:520px;">
    <div class="auth-logo">
      <img src="<?php echo BASE_URL; ?>assets/images/logo.png" alt="Logo" onerror="this.style.display='none'">
      <h1>CaneDae ThirdHome<br><span style="color:var(--gold);font-family:'Playfair Display',serif;font-style:italic;">Catering</span></h1>
    </div>

    <h2>Create Account</h2>
    <p class="auth-subtitle">Register to start booking your catering events</p>

    <?php if($error): ?>
      <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST" action="">
      <div class="form-row">
        <div class="form-group">
          <label>First Name *</label>
          <input type="text" name="first_name" placeholder="Juan"
                 value="<?php echo htmlspecialchars($_POST['first_name'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
          <label>Last Name *</label>
          <input type="text" name="last_name" placeholder="Dela Cruz"
                 value="<?php echo htmlspecialchars($_POST['last_name'] ?? ''); ?>" required>
        </div>
      </div>
      <div class="form-group">
        <label>Email Address *</label>
        <input type="email" name="email" placeholder="you@example.com"
               value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
      </div>
      <div class="form-group">
        <label>Phone Number</label>
        <input type="tel" name="phone" placeholder="+63 9XX XXX XXXX"
               value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>">
      </div>
      <div class="form-row">
        <div class="form-group">
          <label>Password * <small style="font-weight:400;color:#888;">(min 8 chars)</small></label>
          <input type="password" name="password" placeholder="••••••••" required minlength="8">
        </div>
        <div class="form-group">
          <label>Confirm Password *</label>
          <input type="password" name="confirm_pw" placeholder="••••••••" required>
        </div>
      </div>
      <div class="form-group">
        <label style="display:flex; gap:8px; align-items:flex-start; font-weight:400;">
          <input type="checkbox" name="agree_terms" value="1" required style="width:auto; margin-top:4px;"
                 <?php echo !empty($_POST['agree_terms']) ? 'checked' : ''; ?>>
          <span>I have read and agree to the
            <a href="<?php echo BASE_URL; ?>pages/terms.php" target="_blank" rel="noopener" style="text-decoration:underline;">Terms and Conditions</a>.</span>
        </label>
      </div>
      <button type="submit" class="btn-submit">Create Account</button>
    </form>

    <p class="auth-link">
      Already have an account? <a href="login.php">Login here</a>
    </p>

  </div>
</div>

<?php include '../includes/footer.php'; ?>