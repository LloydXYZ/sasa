<?php $title = 'Reservation – Sasa Beach Resort';
include 'inc/header.php';
$cot = $pdo->query("SELECT * FROM cottages WHERE status='available' ORDER BY cottage_no")->fetchAll();
$err = [];
$done = null;
$pk = $_SESSION['pick'] ?? [];
$sel = (int) ($_GET['c'] ?? $pk['c'] ?? 0);
$V = fn($k) => $_POST[$k] ?? $pk[$k] ?? '';
$ids0 = $_POST ? array_map('intval', $_POST['cottages'] ?? []) : [$sel];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $n = trim($_POST['name'] ?? '');
  $tel = trim($_POST['contact'] ?? '');
  $d = $_POST['date'] ?? '';
  $g = (int) ($_POST['guests'] ?? 0);
  $t = $_POST['type'] ?? '';
  $tm = $_POST['time'] ?? '';
  $sr = trim($_POST['request'] ?? '');
  $ids = $ids0;
  $pay = ($_POST['pay'] ?? '') == 'ewallet' ? 'ewallet' : 'resort';
  $ref = trim($_POST['ref'] ?? '');
  if (!$n)
    $err[] = 'Enter your name.';
  if (!preg_match('/^[0-9+\- ]{7,20}$/', $tel))
    $err[] = 'Enter a valid contact number.';
  if (!$d || $d < date('Y-m-d'))
    $err[] = 'Choose today or a future date.';
  if (!in_array($t, ['day', 'overnight']))
    $err[] = 'Choose day use or overnight.';
  // if (!$tm)
  //   $err[] = 'Choose your arrival time.';
  if (!$ids)
    $err[] = 'Choose at least one cottage.';
  if ($g < 1)
    $err[] = 'Enter the number of guests.';
  $proof = null;
  if ($pay == 'ewallet') {
    if (strlen($ref) < 4)
      $err[] = 'Enter your e-wallet reference number.';
    $proof = save_img($_FILES['proof'] ?? [], 'proofs');
    if (!$proof)
      $err[] = $GLOBALS['uerr'] ?: 'Upload a screenshot of your payment.';
  }
  if (!$err) {
    $valid = array_column($cot, null, 'id');
    $total = 0;
    $cap = 0;
    $m = $t == 'overnight' ? mult() : 1;
    $taken = booked_ids($d, $t);
    foreach ($ids as $i) {
      if (!isset($valid[$i]) || in_array($i, $taken)) {
        $err[] = 'A chosen cottage is no longer available on that date. Please pick another.';
        break;
      }
      $total += $valid[$i]['price'] * $m;
      $cap += $valid[$i]['capacity'];
    }
    if (!$err && $g > $cap)
      $err[] = "$g guests need more cottages. Each cottage fits up to 15 people.";
  }
  if (!$err) {
    try {
      $pdo->beginTransaction();
      $tok = bin2hex(random_bytes(16));
      $pdo->prepare('INSERT INTO reservations(name,contact_number,reservation_date,guests,type,arrival_time,special_request,total_amount,down_payment,token,payment_method,payment_ref,payment_proof,payment_status) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?)')->execute([$n, $tel, $d, $g, $t, $tm, $sr, $total, $total / 2, $tok, $pay, $ref ?: null, $proof, $pay == 'ewallet' ? 'submitted' : 'unpaid']);
      $rid = $pdo->lastInsertId();
      foreach ($ids as $i)
        $pdo->prepare('INSERT INTO reservation_cottages VALUES(?,?)')->execute([$rid, $i]);
      $pdo->commit();
      unset($_SESSION['pick']);
      $done = ['id' => $rid, 'total' => $total, 'tok' => $tok, 'pay' => $pay];
    } catch (Exception $x) {
      $pdo->rollBack();
      $err[] = 'Could not save your reservation. Please try again.';
    }
  }
}
?>
<section>
  <div class="wrap" style="max-width:720px">
    <h2>Reservation</h2>
    <?php if ($done): ?>
      <div class="note">
        <h3>Reservation request sent</h3>
        <p>Reference <b>#<?= $done['id'] ?></b> · Total <b>₱<?= number_format($done['total']) ?></b> · 50% down payment
          <b>₱<?= number_format($done['total'] / 2) ?></b>.
        </p>
        <p>
          <?= $done['pay'] == 'ewallet' ? 'The resort will verify your e-wallet payment. After it is verified, your receipt appears on your tracking page.' : 'Please pay the 50% down payment at the resort to secure your reservation.' ?>
        </p>
        <p><b>Save this link</b> to check your payment and print your receipt:<br><a
            href="receipt.php?t=<?= $done['tok'] ?>">Open my reservation page</a></p>
      </div>
      <div class="row"><a class="btn" href="receipt.php?t=<?= $done['tok'] ?>">Track my reservation</a><a class="btn alt"
          style="background:var(--sea)" href="index.php">Back to home</a></div>
    <?php else:
      foreach ($err as $m)
        echo '<p class="err">' . e($m) . '</p>';
      foreach ($cot as $x)
        if ($x['id'] == $sel)
          echo '<div class="selbox"><img src="' . e(cimg($x)) . '" alt=""><div><b>' . e(cname($x)) . '</b><br>₱' . number_format($x['price']) . ' day · ₱' . number_format($x['price'] * mult()) . ' overnight<br><a href="cottages.php#choose">Change cottage</a></div></div>'; ?>
      <p>Overnight stays cost <?= mult() ?>× the day rate.</p>
      <form method="post" enctype="multipart/form-data"><label>Name<input name="name" required
            value="<?= e($_POST['name'] ?? '') ?>"></label><label>Contact number<input name="contact" required
            value="<?= e($_POST['contact'] ?? '') ?>"></label>
        <label>Date<input type="date" id="date" name="date" min="<?= date('Y-m-d') ?>" required
            value="<?= e($V('date')) ?>"></label>
        <label>Stay type<select name="type" id="type">
            <option value="day">Day use (<?= e(setting('day_hours')) ?>)</option>
            <option value="overnight" <?= $V('type') == 'overnight' ? 'selected' : '' ?>>Overnight
              (<?= e(setting('night_hours')) ?>)</option>
          </select></label>
        <label>Arrival time (Optional)<input type="time" name="time"
            value="<?= e($_POST['time'] ?? '') ?>"></label><label>Number of guests<input type="number" min="1"
            name="guests" id="guests" required value="<?= e($_POST['guests'] ?? '') ?>"></label>
        <label>Cottages (add more if you have over 15 guests)</label>
        <div class="pick"><?php foreach ($cot as $x): ?><label id="l<?= $x['id'] ?>"><input type="checkbox"
                name="cottages[]" value="<?= $x['id'] ?>" data-p="<?= $x['price'] ?>" <?= in_array($x['id'], $ids0) ? 'checked' : '' ?>>
              <?= e(cname($x)) ?></label><?php endforeach; ?></div>
        <label>Special request<textarea name="request" rows="2"><?= e($_POST['request'] ?? '') ?></textarea></label>
        <label>Down payment</label><select name="pay" id="pay">
          <option value="resort">Pay at the resort</option>
          <option value="ewallet" <?= ($_POST['pay'] ?? '') == 'ewallet' ? 'selected' : '' ?>>Pay now by e-wallet</option>
        </select>
        <div class="ew" id="ew" style="display:none">
          <p>Send the down payment to <b><?= e(setting('ewallet_name')) ?>
              <?= e(setting('ewallet_number') ?: '(number not set yet, ask the resort)') ?></b>
            <?= e(setting('ewallet_holder')) ?><br>Amount: <b id="dp">₱0</b>
          </p><label>E-wallet reference number<input name="ref" id="ref"
              value="<?= e($_POST['ref'] ?? '') ?>"></label><label>Screenshot of your payment<input type="file"
              name="proof" id="proof" accept="image/*"></label>
        </div>
        <div class="note" id="sum">Total: ₱0</div><button class="btn">Send reservation request</button>
      </form>
      <script>const M = <?= mult() ?>; const $ = s => document.querySelector(s), bx = [...document.querySelectorAll('.pick input')];
        function sum() { let t = 0, c = 0; bx.forEach(b => { if (b.checked) { t += +b.dataset.p * ($('#type').value == 'overnight' ? M : 1); c++ } }); const g = +$('#guests').value || 0; $('#sum').innerHTML = 'Total: <b>₱' + t.toLocaleString() + '</b> · 50% down payment: <b>₱' + (t / 2).toLocaleString() + '</b>' + (g > c * 15 ? '<br><b>' + g + ' guests need ' + Math.ceil(g / 15) + ' cottages.</b>' : ''); $('#dp').textContent = '₱' + (t / 2).toLocaleString() }
        function pay() { const w = $('#pay').value == 'ewallet'; $('#ew').style.display = w ? 'block' : 'none'; $('#ref').required = $('#proof').required = w }
        async function avail() { if (!$('#date').value) return; const r = await (await fetch('availability.php?date=' + $('#date').value + '&type=' + $('#type').value)).json(); bx.forEach(b => { const off = r.includes(+b.value); b.disabled = off; if (off) b.checked = false; b.parentNode.className = off ? 'off' : '' }); sum() }
        ['date', 'type'].forEach(i => $('#' + i).onchange = avail); $('#guests').oninput = sum; $('#pay').onchange = pay; bx.forEach(b => b.onchange = sum); pay(); avail(); sum();</script>
    <?php endif; ?>
  </div>
</section>
<?php include 'inc/footer.php';
