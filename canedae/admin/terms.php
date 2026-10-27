<?php
require_once __DIR__ . '/includes/admin_guard.php';
require_once __DIR__ . '/../includes/terms_default.php';
$page_title = 'Terms & Conditions';
$admin_page = 'terms';
$db = getDB();
$db->exec("CREATE TABLE IF NOT EXISTS settings (
    setting_key VARCHAR(100) PRIMARY KEY,
    setting_value TEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	csrf_verify();
	$act = $_POST['action'] ?? '';
	if ($act === 'reset') {
		$db->exec("DELETE FROM settings WHERE setting_key IN ('terms_content','terms_updated')");
		flash('Terms restored to the default text.');
	} elseif ($act === 'save') {
		$text = str_replace("\r\n", "\n", trim($_POST['terms'] ?? ''));
		if ($text === '')
			flash('The terms cannot be empty. Use "Restore default" instead.', true);
		elseif (strlen($text) > 60000)
			flash('The text is too long (maximum about 60,000 characters).', true);
		else {
			$up = $db->prepare("INSERT INTO settings (setting_key, setting_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)");
			$up->execute(['terms_content', $text]);
			$up->execute(['terms_updated', date('F j, Y')]);
			flash('Terms saved. Customers see the new version now.');
		}
	}
	redirect(BASE_URL . 'admin/terms.php');
}

$saved = $db->query("SELECT setting_value FROM settings WHERE setting_key = 'terms_content'")->fetchColumn();
$using_default = !($saved !== false && trim((string) $saved) !== '');
$text = $using_default ? termsDefault() : $saved;
include __DIR__ . '/includes/admin_header.php';
showFlash();
?>
<div class="panel" style="max-width:900px">
	<p style="margin-top:0;color:var(--muted)">
		Edit the text customers see on the Terms and Conditions page. Start a line with <code>##</code> to make a heading
		(example: <code>## 1. Reservations</code>). Leave a blank line between paragraphs.
		<?php echo $using_default ? 'You are currently showing the default text.' : ''; ?>
	</p>
	<form method="POST">
		<?php echo csrf_field(); ?><input type="hidden" name="action" value="save">
		<textarea name="terms" rows="26" style="font-family:Consolas,monospace;font-size:.9rem;line-height:1.5"
			required><?php echo e($text); ?></textarea>
		<button class="btn btn-green">Save terms</button>
		<a class="btn btn-gold" href="<?php echo BASE_URL; ?>pages/terms.php" target="_blank" rel="noopener">View on
			website</a>
	</form>
	<form method="POST" style="margin-top:14px">
		<?php echo csrf_field(); ?>
		<button class="btn btn-red" name="action" value="reset"
			onclick="return confirm('Replace your text with the default terms?')">Restore default</button>
	</form>
</div>
<?php include __DIR__ . '/includes/admin_footer.php'; ?>