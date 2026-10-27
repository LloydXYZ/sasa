<?php
require_once __DIR__ . '/includes/admin_guard.php';
$page_title = 'Payment settings';
$admin_page = 'settings';
$db = getDB();
$db->exec("CREATE TABLE IF NOT EXISTS settings (
    setting_key VARCHAR(100) PRIMARY KEY,
    setting_value TEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)");
$cur = ['gcash_name' => '', 'gcash_number' => '', 'gcash_qr' => ''];
foreach ($db->query("SELECT setting_key, setting_value FROM settings")->fetchAll() as $r)
	if (array_key_exists($r['setting_key'], $cur))
		$cur[$r['setting_key']] = (string) $r['setting_value'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	csrf_verify();
	try {
		$name = trim($_POST['gcash_name'] ?? '');
		$num = trim($_POST['gcash_number'] ?? '');
		if ($name === '' || mb_strlen($name) > 100)
			throw new RuntimeException('Enter the GCash account name (up to 100 characters).');
		if (!preg_match('/^[0-9+\-\s()]{7,20}$/', $num))
			throw new RuntimeException('Enter a valid GCash number, for example 09XX XXX XXXX.');
		$qr = !empty($_POST['remove_qr']) ? '' : (saveImage('gcash_qr', $cur['gcash_qr']) ?? '');
		$up = $db->prepare("INSERT INTO settings (setting_key, setting_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)");
		foreach (['gcash_name' => $name, 'gcash_number' => $num, 'gcash_qr' => $qr] as $k => $v)
			$up->execute([$k, $v]);
		flash('Payment settings saved.');
	} catch (Throwable $e) {
		flash($e->getMessage(), true);
	}
	redirect(BASE_URL . 'admin/settings.php');
}
include __DIR__ . '/includes/admin_header.php';
showFlash();
?>
<div class="panel" style="max-width:560px">
	<h2>GCash details shown to customers</h2>
	<p style="color:var(--muted)">These appear on the customer payment page. Changes take effect immediately.</p>
	<form method="POST" enctype="multipart/form-data">
		<?php echo csrf_field(); ?>
		<label class="f">Account name</label>
		<input type="text" name="gcash_name" value="<?php echo e($cur['gcash_name']); ?>" maxlength="100" required>
		<label class="f">GCash number</label>
		<input type="text" name="gcash_number" value="<?php echo e($cur['gcash_number']); ?>" placeholder="09XX XXX XXXX"
			required>
		<label class="f">QR code image (JPG, PNG, WEBP · max 3 MB)</label>
		<?php if ($cur['gcash_qr']): ?>
			<img src="<?php echo e(BASE_URL . $cur['gcash_qr']); ?>" alt="Current GCash QR"
				style="max-width:200px;border:1px solid var(--line);display:block;margin:8px 0">
			<label><input type="checkbox" name="remove_qr" value="1"> Remove current QR code</label>
		<?php endif; ?>
		<input type="file" name="gcash_qr" accept=".jpg,.jpeg,.png,.webp">
		<button class="btn btn-green">Save settings</button>
	</form>
</div>
<?php include __DIR__ . '/includes/admin_footer.php'; ?>