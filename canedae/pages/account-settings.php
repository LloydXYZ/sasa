<?php
// pages/account-settings.php – Account Settings matching the UI mockup
require_once '../config/db.php';
startSession();
requireLogin();

$page_title = 'Account Settings';
$db = getDB();

$user_id = $_SESSION['user_id'];

// Handle update
$success = '';
$error = '';
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name  = trim($_POST['last_name'] ?? '');
    $phone      = trim($_POST['phone'] ?? '');
    $birthdate  = trim($_POST['birthdate'] ?? '');
    $username   = trim($_POST['username'] ?? '');

    $upd = $db->prepare("UPDATE users SET first_name = ?, last_name = ?, phone = ?, birthdate = ?, username = ? WHERE id = ?");
    $upd->execute([$first_name, $last_name, $phone, $birthdate, $username, $user_id]);
    $success = 'Profile updated successfully!';
}

// Fetch current user details
$stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

$full_name = trim(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? ''));
if (empty($full_name)) $full_name = 'Aoi Ash';
$email = $user['email'] ?? 'aoiasb85@gmail.com';
$phone = $user['phone'] ?? '09123456789';
$birthdate = $user['birthdate'] ?? 'July -- 2005';
$username = $user['username'] ?? 'HelloWorldKumbaga';
$profile_img = !empty($user['profile_picture']) ? BASE_URL . $user['profile_picture'] : BASE_URL . 'assets/images/profile_sample.jpg';

include '../includes/header.php';
?>

<div class="page-container" style="max-width: 960px;">
  <!-- Title & Subtitle matching the mockup -->
  <div style="margin-bottom: 24px;">
    <h1 style="font-family:'Playfair Display', serif; font-size: 2.4rem; font-weight: 700; color: #1a140e; margin-bottom: 2px;">
      Account Settings
    </h1>
    <p style="font-family:'Playfair Display', serif; font-size: 1.05rem; color: #3a2e22;">
      Basic Information
    </p>
  </div>

  <?php if($success): ?>
    <div style="background:#d1fae5; border:1px solid #10b981; color:#065f46; padding:12px 18px; border-radius:8px; margin-bottom:20px; font-weight:600;">
      <?php echo htmlspecialchars($success); ?>
    </div>
  <?php endif; ?>

  <!-- White Rounded Card -->
  <div class="design-card" style="padding: 36px 44px;">
    <div class="account-settings-grid">
      <!-- Left: Profile Picture -->
      <div>
        <div style="font-family:'Playfair Display', serif; font-size: 1.15rem; color: #1a140e; margin-bottom: 12px;">
          Profile Picture:
        </div>
        <div class="profile-avatar-frame">
          <img src="<?php echo htmlspecialchars($profile_img); ?>" 
               alt="Profile Picture"
               onerror="this.src='https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=500'">
        </div>
      </div>

      <!-- Right: User Information -->
      <div style="display: flex; flex-direction: column; gap: 14px; font-family:'Playfair Display', serif; font-size: 1.15rem; color: #1a140e;">
        <div>
          <span>Name: <?php echo htmlspecialchars($full_name); ?></span>
        </div>
        <div>
          <span>Date of Birth: <?php echo htmlspecialchars($birthdate); ?></span>
        </div>
        <div>
          <span>Email: <?php echo htmlspecialchars($email); ?></span>
        </div>
        <div>
          <span>Contact Number: <?php echo htmlspecialchars($phone); ?></span>
        </div>

        <div style="border-top: 1px solid #33261a; margin: 10px 0 6px;"></div>

        <div>
          <span>Username: <?php echo htmlspecialchars($username); ?></span>
        </div>
        <div>
          <span>Password: **************</span>
        </div>

        <div style="text-align: right; margin-top: 16px;">
          <button type="button" onclick="openEditModal()" class="btn-gold" style="padding: 9px 36px;">
            Edit Info
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Edit Profile Modal -->
<div id="editProfileModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center;">
  <div class="design-card" style="max-width:500px; width:90%; padding:32px;">
    <h3 style="font-family:'Playfair Display', serif; font-size:1.4rem; margin-bottom:18px;">Edit Profile Information</h3>
    <form method="POST">
      <input type="hidden" name="update_profile" value="1">
      <div style="margin-bottom:12px;">
        <label class="res-form-label">First Name:</label>
        <input type="text" name="first_name" class="form-input-bordered" value="<?php echo htmlspecialchars($user['first_name'] ?? 'Aoi'); ?>" required>
      </div>
      <div style="margin-bottom:12px;">
        <label class="res-form-label">Last Name:</label>
        <input type="text" name="last_name" class="form-input-bordered" value="<?php echo htmlspecialchars($user['last_name'] ?? 'Ash'); ?>" required>
      </div>
      <div style="margin-bottom:12px;">
        <label class="res-form-label">Date of Birth:</label>
        <input type="text" name="birthdate" class="form-input-bordered" value="<?php echo htmlspecialchars($birthdate); ?>">
      </div>
      <div style="margin-bottom:12px;">
        <label class="res-form-label">Contact Number:</label>
        <input type="text" name="phone" class="form-input-bordered" value="<?php echo htmlspecialchars($phone); ?>" required>
      </div>
      <div style="margin-bottom:20px;">
        <label class="res-form-label">Username:</label>
        <input type="text" name="username" class="form-input-bordered" value="<?php echo htmlspecialchars($username); ?>" required>
      </div>
      <div style="display:flex; justify-content:flex-end; gap:12px;">
        <button type="button" onclick="closeEditModal()" class="btn-silver-pill" style="padding:8px 24px;">Cancel</button>
        <button type="submit" class="btn-forest" style="padding:8px 24px;">Save Changes</button>
      </div>
    </form>
  </div>
</div>

<script>
function openEditModal() {
  document.getElementById('editProfileModal').style.display = 'flex';
}
function closeEditModal() {
  document.getElementById('editProfileModal').style.display = 'none';
}
</script>

<?php include '../includes/footer.php'; ?>
