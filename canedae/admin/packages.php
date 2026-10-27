<?php
require_once __DIR__ . '/includes/admin_guard.php';
$page_title = 'Packages'; $admin_page = 'packages';
$db = getDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
    $act = $_POST['action'] ?? '';
    try {
        if ($act === 'toggle') {
            $db->prepare("UPDATE packages SET is_active = 1 - is_active WHERE id = ?")->execute([(int)$_POST['id']]);
            flash('Visibility updated.');
        } elseif ($act === 'save') {
            $id = (int)($_POST['id'] ?? 0);
            $name = trim($_POST['name'] ?? '');
            if ($name === '') throw new RuntimeException('Package name is required.');
            $old = null;
            if ($id) { $o = $db->prepare("SELECT image FROM packages WHERE id=?"); $o->execute([$id]); $old = $o->fetchColumn() ?: null; }
            $img = saveImage('image', $old);
            $v = [$name, trim($_POST['description'] ?? ''), max(0, (int)($_POST['pax_min'] ?? 0)), max(0, (int)($_POST['pax_max'] ?? 0)),
                  max(0, (float)($_POST['price_min'] ?? 0)), max(0, (float)($_POST['price_max'] ?? 0)),
                  trim($_POST['inclusions'] ?? ''), $img, isset($_POST['is_active']) ? 1 : 0];
            if ($id) {
                $v[] = $id;
                $db->prepare("UPDATE packages SET name=?,description=?,pax_min=?,pax_max=?,price_min=?,price_max=?,inclusions=?,image=?,is_active=? WHERE id=?")->execute($v);
                flash('Package saved.');
            } else {
                $db->prepare("INSERT INTO packages (name,description,pax_min,pax_max,price_min,price_max,inclusions,image,is_active) VALUES (?,?,?,?,?,?,?,?,?)")->execute($v);
                flash('Package added.');
            }
        }
    } catch (Throwable $e) { flash($e->getMessage(), true); }
    redirect(BASE_URL . 'admin/packages.php');
}

$rows = $db->query("SELECT * FROM packages ORDER BY id")->fetchAll();
$edit = null;
if (isset($_GET['edit'])) { $s = $db->prepare("SELECT * FROM packages WHERE id=?"); $s->execute([(int)$_GET['edit']]); $edit = $s->fetch() ?: null; }
$form = $edit ?: ['id'=>0,'name'=>'','description'=>'','pax_min'=>0,'pax_max'=>0,'price_min'=>0,'price_max'=>0,'inclusions'=>'','image'=>'','is_active'=>1];
$show_form = $edit || isset($_GET['new']);
include __DIR__ . '/includes/admin_header.php';
showFlash();
?>
<p><a class="btn btn-green" href="?new=1">+ Add package</a></p>
<div class="table-wrap"><table>
  <tr><th></th><th>Name</th><th>Guests</th><th>Price</th><th>Status</th><th></th></tr>
  <?php foreach ($rows as $r): ?>
  <tr>
    <td><?php if ($r['image']): ?><img class="thumb" src="<?php echo e(BASE_URL . $r['image']); ?>" alt=""><?php endif; ?></td>
    <td><?php echo e($r['name']); ?></td>
    <td><?php echo (int)$r['pax_min']; ?><?php echo $r['pax_max'] != $r['pax_min'] ? '–' . (int)$r['pax_max'] : ''; ?></td>
    <td><?php echo e(formatPrice($r['price_min'])); ?></td>
    <td><?php echo statusPill($r['is_active'] ? 'Active' : 'Hidden'); ?></td>
    <td>
      <a href="?edit=<?php echo (int)$r['id']; ?>">Edit</a> ·
      <a href="menu.php?package_id=<?php echo (int)$r['id']; ?>">Menu items</a> ·
      <form method="POST" class="inline"><?php echo csrf_field(); ?><input type="hidden" name="id" value="<?php echo (int)$r['id']; ?>">
        <button class="btn" name="action" value="toggle"><?php echo $r['is_active'] ? 'Hide' : 'Show'; ?></button></form>
    </td>
  </tr>
  <?php endforeach; ?>
</table></div>

<?php if ($show_form): ?>
<div class="panel" style="margin-top:20px">
  <h2><?php echo $edit ? 'Edit package' : 'New package'; ?></h2>
  <form method="POST" enctype="multipart/form-data">
    <?php echo csrf_field(); ?><input type="hidden" name="action" value="save"><input type="hidden" name="id" value="<?php echo (int)$form['id']; ?>">
    <label class="f">Name</label><input type="text" name="name" value="<?php echo e($form['name']); ?>" required>
    <label class="f">Description</label><textarea name="description" rows="3"><?php echo e($form['description']); ?></textarea>
    <div class="row2">
      <div><label class="f">Guests (min)</label><input type="number" name="pax_min" min="0" value="<?php echo (int)$form['pax_min']; ?>"></div>
      <div><label class="f">Guests (max)</label><input type="number" name="pax_max" min="0" value="<?php echo (int)$form['pax_max']; ?>"></div>
      <div><label class="f">Price (this is what customers are charged)</label><input type="number" name="price_min" min="0" step="0.01" value="<?php echo e($form['price_min']); ?>"></div>
      <div><label class="f">Price (max, display only)</label><input type="number" name="price_max" min="0" step="0.01" value="<?php echo e($form['price_max']); ?>"></div>
    </div>
    <label class="f">Inclusions</label><textarea name="inclusions" rows="3"><?php echo e($form['inclusions']); ?></textarea>
    <label class="f">Image (JPG, PNG, WEBP · max 3 MB)</label>
    <?php if ($form['image']): ?><img class="thumb" src="<?php echo e(BASE_URL . $form['image']); ?>" alt=""><?php endif; ?>
    <input type="file" name="image" accept=".jpg,.jpeg,.png,.webp">
    <label><input type="checkbox" name="is_active" value="1" <?php echo $form['is_active'] ? 'checked' : ''; ?>> Visible to customers</label><br><br>
    <button class="btn btn-green">Save package</button> <a href="packages.php">Cancel</a>
  </form>
</div>
<?php endif; ?>
<?php include __DIR__ . '/includes/admin_footer.php'; ?>
