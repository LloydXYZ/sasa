<?php
// pages/terms.php – Terms and Conditions (public page). Text is edited in Admin > Terms & Conditions.
require_once '../config/db.php';
require_once '../includes/terms_default.php';
startSession();
$page_title = 'Terms and Conditions';

$terms_text = '';
$terms_updated = '';
try {
	$rows = getDB()->query("SELECT setting_key, setting_value FROM settings WHERE setting_key IN ('terms_content','terms_updated')")->fetchAll();
	foreach ($rows as $r) {
		if ($r['setting_key'] === 'terms_content')
			$terms_text = (string) $r['setting_value'];
		if ($r['setting_key'] === 'terms_updated')
			$terms_updated = (string) $r['setting_value'];
	}
} catch (Throwable $e) { /* settings table not created yet */
}
if (trim($terms_text) === '')
	$terms_text = termsDefault();

include '../includes/header.php';
?>
<div class="page-container" style="max-width: 860px;">
	<h1
		style="font-family:'Playfair Display', serif; font-size:2.4rem; font-weight:700; color:#1a140e; margin-bottom:4px;">
		Terms and Conditions</h1>
	<p style="font-family:'Playfair Display', serif; color:#4a3e30; margin-bottom:24px;">
		CaneDae ThirdHome Catering<?php echo $terms_updated ? ' · Last updated ' . htmlspecialchars($terms_updated) : ''; ?>
	</p>

	<div class="design-card" style="padding:28px 36px; line-height:1.7;">
		<?php echo termsRender($terms_text); ?>
	</div>

	<p style="margin-top:22px;"><a href="javascript:history.back()" class="btn-navy" style="padding:10px 28px;">Back</a>
	</p>
</div>
<?php include '../includes/footer.php'; ?>