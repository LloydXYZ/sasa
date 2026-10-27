<?php
require_once __DIR__ . '/includes/admin_guard.php';
$page_title = 'Menu items'; $admin_page = 'menu';
$db = getDB();
$pkgs = $db->query("SELECT id, name FROM packages ORDER BY id")->fetchAll();
$pid = (int)($_GET['package_id'] ?? ($_POST['package_id'] ?? ($pkgs[0]['id'] ?? 0)));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
    $act = $_POST['action'] ?? '';
    $cat = trim($_POST['category'] ?? ''); $name = trim($_POST['item_name'] ?? '');
    if ($act === 'add') {
        if ($cat === '' || $name === '') flash('Category and item name are required.', true);
        else { $db->prepare("INSERT INTO menu_items (package_id, category, item_name) VALUES (?,?,?)")->execute([$pid, $cat, $name]); flash('Item added.'); }
    } elseif ($act === 'save') {
        if ($cat === '' || $name === '') flash('Category and item name are required.', true);
        else { $db->prepare("UPDATE menu_items SET category=?, item_name=? WHERE id=? AND package_id=?")->execute([$cat, $name, (int)$_POST['id'], $pid]); flash('Item saved.'); }
    } elseif ($act === 'toggle') {
        $db->prepare("UPDATE menu_items SET is_active = 1 - is_active WHERE id=? AND package_id=?")->execute([(int)$_POST['id'], $pid]);
        flash('Visibility updated.');
    }
    redirect(BASE_URL . 'admin/menu.php?package_id=' . $pid);
}

$st = $db->prepare("SELECT * FROM menu_items WHERE package_id = ? ORDER BY category, item_name");
$st->execute([$pid]); $items = $st->fetchAll();
$cats = array_values(array_unique(array_column($items, 'category')));
include __DIR__ . '/includes/admin_header.php';
showFlash();
?>
<?php if (!$pkgs): ?><div class="empty">Add a package first.</div><?php else: ?>
<form method="GET" style="max-width:360px"><label class="f">Package</label>
  <select name="package_id" onchange="this.form.submit()"><?php foreach ($pkgs as $p): ?>
    <option value="<?php echo (int)$p['id']; ?>" <?php echo $p['id'] == $pid ? 'selected' : ''; ?>><?php echo e($p['name']); ?></option><?php endforeach; ?></select></form>
<datalist id="cats"><?php foreach ($cats as $c): ?><option value="<?php echo e($c); ?>"><?php endforeach; ?></datalist>

<div class="panel"><h2>Add item</h2>
  <form method="POST" class="row2"><?php echo csrf_field(); ?><input type="hidden" name="package_id" value="<?php echo $pid; ?>">
    <div><input type="text" name="category" list="cats" placeholder="Category (e.g. Main Course)" required></div>
    <div><input type="text" name="item_name" placeholder="Item name" required></div>
    <div><button class="btn btn-green" name="action" value="add">Add item</button></div>
  </form></div>

<div class="table-wrap"><table>
  <tr><th>Category</th><th>Item</th><th>Status</th><th></th></tr>
  <?php foreach ($items as $it): ?>
  <form method="POST"><?php echo csrf_field(); ?><input type="hidden" name="package_id" value="<?php echo $pid; ?>"><input type="hidden" name="id" value="<?php echo (int)$it['id']; ?>">
  <tr>
    <td><input type="text" name="category" list="cats" value="<?php echo e($it['category']); ?>" style="margin:0"></td>
    <td><input type="text" name="item_name" value="<?php echo e($it['item_name']); ?>" style="margin:0"></td>
    <td><?php echo statusPill($it['is_active'] ? 'Active' : 'Hidden'); ?></td>
    <td><button class="btn" name="action" value="save">Save</button>
        <button class="btn btn-gold" name="action" value="toggle"><?php echo $it['is_active'] ? 'Hide' : 'Show'; ?></button></td>
  </tr></form>
  <?php endforeach; ?>
  <?php if (!$items): ?><tr><td colspan="4" class="empty">No items for this package yet.</td></tr><?php endif; ?>
</table></div>
<p style="color:var(--muted)">Items are hidden, not deleted, so past reservations keep their menu.</p>
<?php endif; ?>
<?php include __DIR__ . '/includes/admin_footer.php'; ?>
