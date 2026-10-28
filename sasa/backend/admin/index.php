<?php require '../config.php';
if (empty($_SESSION['admin'])) {
  header('Location: login.php');
  exit;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !$_POST && ($_SERVER['CONTENT_LENGTH'] ?? 0) > 0) {
  flash('err', 'The upload was too large for the server. Please use a smaller picture.');
  header('Location: index.php?p=cot');
  exit;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $P = $_POST;
  $a = $P['a'] ?? '';
  $id = (int) ($P['id'] ?? 0);
  if ($a == 'status' && in_array($P['st'] ?? '', ['approved', 'rejected', 'cancelled']))
    $pdo->prepare('UPDATE reservations SET status=? WHERE id=?')->execute([$P['st'], $id]) && flash('ok', 'Reservation #' . $id . ' marked as ' . $P['st'] . '.');
  if ($a == 'pay')
    $pdo->prepare(($P['v'] ?? '') == 'ok' ? "UPDATE reservations SET payment_status='verified',paid_at=NOW(),status='approved' WHERE id=?" : "UPDATE reservations SET payment_status='rejected' WHERE id=?")->execute([$id]) && flash('ok', ($P['v'] ?? '') == 'ok' ? 'Payment verified. Reservation #' . $id . ' is now approved.' : 'Payment rejected for reservation #' . $id . '.');
  if ($a == 'add') {
    $nm = trim($P['name'] ?? '');
    $img = 'beach.jpg';
    $ok = $nm !== '';
    if (!$ok)
      flash('err', 'Please enter the cottage name.');
    elseif (($_FILES['image']['error'] ?? 4) != 4 && !($img = save_img($_FILES['image'], 'cottages'))) {
      flash('err', $GLOBALS['uerr']);
      $ok = false;
    }
    if ($ok) {
      $am = array_filter(array_map('trim', array_merge($P['am'] ?? [], explode(',', $P['other'] ?? ''))));
      $no = 1 + (int) $pdo->query('SELECT MAX(cottage_no) FROM cottages')->fetchColumn();
      $pdo->prepare('INSERT INTO cottages(cottage_no,name,description,amenities,price,capacity,image) VALUES(?,?,?,?,?,?,?)')->execute([$no, $nm, trim($P['description'] ?? ''), implode(',', $am), max(0, (float) $P['price']), max(1, (int) $P['capacity']), $img]);
      flash('ok', 'Cottage “' . $nm . '” was added.');
    }
  }
  if ($a == 'edit') {
    $pdo->prepare('UPDATE cottages SET name=?,price=?,capacity=?,description=?,amenities=?,status=? WHERE id=?')->execute([trim($P['name']), max(0, (float) $P['price']), max(1, (int) $P['capacity']), trim($P['description']), trim($P['amenities']), ($P['cs'] ?? '') == 'maintenance' ? 'maintenance' : 'available', $id]);
    flash('ok', 'Cottage saved.');
    if (($_FILES['image']['error'] ?? 4) != 4) {
      if ($im = save_img($_FILES['image'], 'cottages'))
        $pdo->prepare('UPDATE cottages SET image=? WHERE id=?')->execute([$im, $id]);
      else
        flash('err', $GLOBALS['uerr']);
    }
  }
  if ($a == 'del') {
    if ($pdo->query('SELECT COUNT(*) FROM reservation_cottages WHERE cottage_id=' . $id)->fetchColumn() > 0)
      flash('err', 'This cottage has reservations. Set it to Maintenance instead of deleting it.');
    else {
      $pdo->exec('DELETE FROM cottages WHERE id=' . $id);
      flash('ok', 'Cottage deleted.');
    }
  }
  if ($a == 'set')
    foreach (['entrance_fee', 'overnight_multiplier', 'contact_number', 'email', 'maps_url', 'ewallet_name', 'ewallet_number', 'ewallet_holder'] as $k)
      $pdo->prepare('REPLACE INTO settings VALUES(?,?)')->execute([$k, trim($P[$k])]);
  header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'index.php'));
  exit;
}
$p = in_array($_GET['p'] ?? '', ['res', 'cot', 'set']) ? $_GET['p'] : 'dash';
$m = mult();
$n = fn($q) => $pdo->query($q)->fetchColumn();
$base = '../';
$RQ = "SELECT r.*,GROUP_CONCAT(COALESCE(c.name,CONCAT('Cottage ',c.cottage_no)) ORDER BY c.cottage_no SEPARATOR ', ') cn FROM reservations r LEFT JOIN reservation_cottages rc ON rc.reservation_id=r.id LEFT JOIN cottages c ON c.id=rc.cottage_id";
function nav($k, $l, $p)
{
  return '<a class="' . ($p == $k ? 'on' : '') . '" href="?p=' . $k . '">' . $l . '</a>';
}
?><!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Admin – Sasa Beach Resort</title>
  <link
    href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@600;800&family=Nunito+Sans:wght@400;600&display=swap"
    rel="stylesheet">
  <style>
    * {
      box-sizing: border-box
    }

    body.adm {
      margin: 0;
      display: flex;
      min-height: 100vh;
      font: 16px/1.5 'Nunito Sans', system-ui, sans-serif;
      color: #2f2400;
      background: #fff6d6
    }

    h1,
    h2,
    h3 {
      font-family: 'Bricolage Grotesque', Georgia, sans-serif;
      margin: 0;
      line-height: 1.15
    }

    a {
      color: #8a5a00
    }

    .side {
      width: 240px;
      flex: none;
      position: sticky;
      top: 0;
      height: 100vh;
      padding: 1.5rem 1rem;
      display: flex;
      flex-direction: column;
      gap: .3rem;
      background: linear-gradient(180deg, #8a5a00, #c98a00);
      color: #fff
    }

    .side h1 {
      font-size: 1.6rem;
      margin-bottom: 1.2rem
    }

    .side small {
      display: block;
      font: 400 .85rem 'Nunito Sans', sans-serif;
      opacity: .85
    }

    .side a {
      color: #fff;
      text-decoration: none;
      padding: .6rem .9rem;
      border-radius: 12px;
      font-weight: 700;
      min-height: 44px;
      display: flex;
      align-items: center
    }

    .side a:hover,
    .side a.on {
      background: rgba(255, 255, 255, .22)
    }

    .side a.out {
      margin-top: auto;
      background: #f5b700;
      color: #2f2400;
      justify-content: center
    }

    main {
      flex: 1;
      min-width: 0;
      padding: 2rem 2.5rem
    }

    main h2 {
      font-size: 1.9rem;
      margin-bottom: .7rem
    }

    .hi {
      color: #7a6420;
      margin: 0 0 1.4rem
    }

    .flash {
      padding: .9rem 1.2rem;
      border-radius: 14px;
      margin-bottom: 1rem;
      font-weight: 700
    }

    .flash.ok {
      background: #bdf0c8
    }

    .flash.err {
      background: #ffd0c7
    }

    .stats {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(190px, 1fr));
      gap: 1rem;
      margin-bottom: 1.6rem
    }

    .stat {
      border-radius: 20px;
      padding: 1.1rem 1.3rem;
      color: #fff
    }

    .stat b {
      display: block;
      font: 800 2.1rem 'Bricolage Grotesque', sans-serif
    }

    .s1 {
      background: #c98a00
    }

    .s2 {
      background: #f5b700;
      color: #2f2400
    }

    .s3 {
      background: #8a5a00
    }

    .s4 {
      background: #e0662a
    }

    .panel {
      background: #fff;
      border-radius: 22px;
      padding: 1.4rem;
      margin-bottom: 1.6rem;
      box-shadow: 0 3px 0 #f0dca0;
      overflow-x: auto
    }

    .panel h3 {
      font-size: 1.25rem;
      margin-bottom: 1rem;
      color: #8a5a00
    }

    .tabs {
      display: flex;
      gap: .5rem;
      margin-bottom: 1rem;
      flex-wrap: wrap
    }

    .tabs a {
      padding: .5rem 1.1rem;
      border-radius: 99px;
      background: #fff4cc;
      text-decoration: none;
      font-weight: 700;
      font-size: .9rem
    }

    .tabs a.on {
      background: #8a5a00;
      color: #fff
    }

    table {
      border-collapse: collapse;
      width: 100%;
      min-width: 700px
    }

    th,
    td {
      padding: .7rem .6rem;
      border-bottom: 1px solid #f0dca0;
      text-align: left;
      vertical-align: top;
      font-size: .95rem
    }

    th {
      color: #7a6420;
      font-size: .85rem;
      white-space: nowrap
    }

    .pill {
      padding: .15rem .7rem;
      border-radius: 99px;
      font-size: .8rem;
      font-weight: 700;
      background: #ecd88f;
      display: inline-block
    }

    .pill.approved,
    .pill.verified {
      background: #bdf0c8
    }

    .pill.rejected,
    .pill.cancelled {
      background: #ffd0c7
    }

    .pill.pending,
    .pill.submitted {
      background: #ffe8a8
    }

    .b {
      border: 0;
      border-radius: 99px;
      padding: .5rem 1.1rem;
      min-height: 44px;
      font: 700 .9rem 'Nunito Sans', sans-serif;
      cursor: pointer;
      color: #fff;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      text-decoration: none
    }

    .b.ok {
      background: #22a35a
    }

    .b.no {
      background: #d9534f
    }

    .b.gr {
      background: #7b8b90
    }

    .b.sv {
      background: #8a5a00
    }

    .b.yl {
      background: #f5b700;
      color: #2f2400
    }

    .row {
      display: flex;
      gap: .6rem;
      flex-wrap: wrap;
      align-items: center
    }

    label {
      display: block;
      font-weight: 700;
      font-size: .9rem;
      margin: .7rem 0 .25rem
    }

    input,
    select,
    textarea {
      width: 100%;
      padding: .6rem .7rem;
      border: 2px solid #ecd88f;
      border-radius: 10px;
      font: inherit;
      background: #fff
    }

    input[type=checkbox] {
      width: auto
    }

    input:focus,
    select:focus,
    textarea:focus,
    summary:focus-visible,
    .b:focus-visible {
      outline: 3px solid #f5b700;
      outline-offset: 2px
    }

    .grid2 {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
      gap: 0 1.2rem
    }

    .addbtn {
      margin-bottom: 1.6rem
    }

    .addbtn>summary {
      list-style: none;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: .5rem;
      background: #f5b700;
      color: #2f2400;
      font-weight: 800;
      padding: .8rem 1.5rem;
      border-radius: 99px;
      min-height: 44px
    }

    .addbtn>summary::-webkit-details-marker {
      display: none
    }

    .addbtn[open]>summary {
      margin-bottom: 1rem
    }

    .addbtn .box {
      background: #fff;
      border-radius: 22px;
      padding: 1.4rem;
      box-shadow: 0 3px 0 #f0dca0
    }

    .chips {
      display: flex;
      flex-wrap: wrap;
      gap: .5rem
    }

    .chip {
      position: relative;
      margin: 0
    }

    .chip input {
      position: absolute;
      opacity: 0;
      width: 1px;
      height: 1px
    }

    .chip span {
      display: inline-block;
      padding: .5rem 1rem;
      border-radius: 99px;
      border: 2px solid #ecd88f;
      background: #fff;
      font-weight: 700;
      cursor: pointer
    }

    .chip input:checked+span {
      background: #f5b700;
      border-color: #f5b700
    }

    .chip input:focus-visible+span {
      outline: 3px solid #8a5a00
    }

    .up {
      display: flex;
      gap: 1rem;
      align-items: center
    }

    .up img {
      width: 96px;
      height: 72px;
      object-fit: cover;
      border-radius: 12px;
      background: #fff4cc;
      flex: none
    }

    .cgrid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
      gap: 1.2rem
    }

    .cc {
      background: #fff;
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 3px 0 #f0dca0;
      display: flex;
      flex-direction: column
    }

    .cc>img {
      width: 100%;
      height: 180px;
      object-fit: cover;
      display: block
    }

    .cc .in {
      padding: 1rem 1.1rem;
      flex: 1
    }

    .cc h3 {
      font-size: 1.2rem;
      display: flex;
      justify-content: space-between;
      gap: .5rem;
      align-items: flex-start
    }

    .cc .pr {
      font-weight: 800;
      color: #8a5a00;
      margin: .3rem 0
    }

    .tags {
      display: flex;
      flex-wrap: wrap;
      gap: .3rem
    }

    .tags span {
      background: #fff4cc;
      border-radius: 99px;
      padding: .1rem .65rem;
      font-size: .8rem
    }

    .cc details {
      border-top: 2px solid #fff4cc;
      padding: .3rem 1.1rem .9rem
    }

    .cc summary {
      cursor: pointer;
      font-weight: 800;
      color: #8a5a00;
      min-height: 44px;
      display: flex;
      align-items: center
    }

    .sales {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 1rem;
      margin-bottom: 1.6rem
    }

    .sale {
      background: #fff;
      border-radius: 20px;
      padding: 1.1rem 1.3rem;
      box-shadow: 0 3px 0 #f0dca0;
      border-top: 6px solid #f5b700
    }

    .sale b {
      display: block;
      font: 800 1.9rem 'Bricolage Grotesque', sans-serif;
      color: #8a5a00
    }

    .sale span {
      color: #7a6420;
      font-size: .9rem
    }

    .sale.big {
      background: #8a5a00;
      border-color: #f5b700
    }

    .sale.big b,
    .sale.big span {
      color: #fff
    }

    @media(max-width:820px) {
      body.adm {
        display: block
      }

      .side {
        width: auto;
        height: auto;
        position: static;
        flex-direction: row;
        flex-wrap: wrap;
        padding: 1rem
      }

      .side h1 {
        width: 100%;
        margin: 0 0 .5rem
      }

      .side a.out {
        margin: 0
      }

      main {
        padding: 1rem
      }
    }
  </style>
</head>

<body class="adm">
  <aside class="side">
    <h1>Sasa Beach<small>Resort admin</small></h1>
    <?= nav('dash', 'Dashboard', $p) . nav('res', 'Reservations', $p) . nav('cot', 'Cottages', $p) . nav('set', 'Settings', $p) ?><a
      href="../../frontend/index.php" target="_blank">View website</a><a class="out" href="logout.php">Log out</a>
  </aside>
  <main>
    <?php if (!empty($_SESSION['fl'])) {
      [$ft, $fm] = $_SESSION['fl'];
      unset($_SESSION['fl']);
      echo '<div class="flash ' . $ft . '">' . e($fm) . '</div>';
    } ?>
    <?php if ($p == 'dash'): ?>
      <h2>Dashboard</h2>
      <p class="hi">A quick look at today.</p>
      <div class="stats">
        <div class="stat s1"><b><?= $n("SELECT COUNT(*) FROM reservations WHERE status='pending'") ?></b>Pending requests
        </div>
        <div class="stat s2">
          <b><?= $n("SELECT COUNT(*) FROM reservations WHERE payment_status='submitted'") ?></b>Payments to verify
        </div>
        <div class="stat s3">
          <b><?= $n("SELECT COUNT(*) FROM reservations WHERE reservation_date=CURDATE() AND status IN('pending','approved')") ?></b>Arriving
          today
        </div>
      </div>
      <h3 style="margin:0 0 .8rem;color:#8a5a00">Sales</h3>
      <div class="sales"><?php $sq = fn($w) => $pdo->query("SELECT COALESCE(SUM(down_payment),0) t,COUNT(*) c FROM reservations WHERE payment_status='verified' $w")->fetch();
      foreach ([['Today', "AND DATE(paid_at)=CURDATE()", ''], ['Yesterday', "AND DATE(paid_at)=CURDATE()-INTERVAL 1 DAY", ''], ['Last 15 days', "AND DATE(paid_at)>=CURDATE()-INTERVAL 14 DAY", ''], ['Overall sales', '', 'big']] as [$l, $w, $cl]) {
        $v = $sq($w);
        echo '<div class="sale ' . $cl . '"><span>' . $l . '</span><b>₱' . number_format((float) $v['t']) . '</b><span>' . $v['c'] . ' verified payment' . ($v['c'] == 1 ? '' : 's') . '</span></div>';
      } ?></div>
      <p class="hi" style="margin-top:-.8rem">Sales are the verified payments received, counted on the day each payment
        was verified.</p>
      <div class="panel">
        <h3>Needs your attention</h3>
        <table><?php $q = $pdo->query("$RQ WHERE r.status='pending' OR r.payment_status='submitted' GROUP BY r.id ORDER BY r.created_at DESC LIMIT 6")->fetchAll();
        foreach ($q as $x): ?>
            <tr>
              <td><b><?= e($x['name']) ?></b><br><small><?= e($x['cn']) ?></small></td>
              <td><?= date('M j', strtotime($x['reservation_date'])) ?></td>
              <td><span class="pill <?= $x['payment_status'] ?>">payment: <?= $x['payment_status'] ?></span></td>
              <td><a class="b sv" href="?p=res">Review</a></td>
            </tr><?php endforeach;
        if (!$q)
          echo '<tr><td>All caught up. Nothing to review.</td></tr>'; ?>
        </table>
      </div>
    <?php elseif ($p == 'res'): $f = $_GET['f'] ?? 'all';
      $w = in_array($f, ['pending', 'approved', 'rejected', 'cancelled']) ? "WHERE r.status='$f'" : '';
      $r = $pdo->query("$RQ $w GROUP BY r.id ORDER BY r.created_at DESC")->fetchAll();
      if (!function_exists('act')) {
        function act($id, $a, $k, $v, $cls, $label)
        {
          return '<form method="post"><input type="hidden" name="a" value="' . $a . '"><input type="hidden" name="id" value="' . $id . '"><button class="b ' . $cls . '" name="' . $k . '" value="' . $v . '">' . $label . '</button></form>';
        }
      } ?>
      <h2>Reservations</h2>
      <div class="tabs"><?php foreach (['all' => 'All', 'pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected', 'cancelled' => 'Cancelled'] as $k => $l)
        echo '<a class="' . ($f == $k ? 'on' : '') . '" href="?p=res&f=' . $k . '">' . $l . '</a>'; ?></div>
      <div class="panel">
        <table>
          <tr>
            <th>Guest</th>
            <th>Date &amp; stay</th>
            <th>Cottages</th>
            <th>Amount</th>
            <th>Payment</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
          <?php foreach ($r as $x):
            $ps = $x['payment_status'];
            $st = $x['status']; ?>
            <tr>
              <td><b>#<?= $x['id'] ?>     <?= e($x['name']) ?></b><br><small><?= e($x['contact_number']) ?> ·
                  <?= $x['guests'] ?> guests</small><?php if ($x['special_request'])
                       echo '<br><small><i>' . e($x['special_request']) . '</i></small>'; ?></td>
              <td><?= date('M j, Y', strtotime($x['reservation_date'])) ?><br><small><?= $x['type'] == 'day' ? 'Day use' : 'Overnight' ?>
                  · <?= substr($x['arrival_time'], 0, 5) ?></small></td>
              <td><?= e($x['cn']) ?></td>
              <td>₱<?= number_format($x['total_amount']) ?><br><small>down ₱<?= number_format($x['down_payment']) ?></small>
              </td>
              <td><span
                  class="pill <?= $ps ?>"><?= $ps ?></span><br><small><?= $x['payment_method'] == 'ewallet' ? 'E-wallet' : 'At resort' ?><?= $x['payment_ref'] ? ' · ' . e($x['payment_ref']) : '' ?></small><?php if ($x['payment_proof'])
                                        echo '<br><a href="proof.php?id=' . $x['id'] . '" target="_blank">View proof</a>'; ?>
              </td>
              <td><span class="pill <?= $st ?>"><?= $st ?></span></td>
              <td>
                <div class="row">
                  <?php if ($ps != 'verified')
                    echo act($x['id'], 'pay', 'v', 'ok', 'ok', 'Verify payment');
                  if ($ps == 'submitted')
                    echo act($x['id'], 'pay', 'v', 'no', 'no', 'Reject payment');
                  if ($ps == 'verified')
                    echo '<span class="pill verified">✓ Paid</span>';
                  if ($st != 'approved')
                    echo act($x['id'], 'status', 'st', 'approved', 'ok', 'Approve');
                  if ($st != 'rejected')
                    echo act($x['id'], 'status', 'st', 'rejected', 'no', 'Reject');
                  if ($st != 'cancelled')
                    echo act($x['id'], 'status', 'st', 'cancelled', 'gr', 'Cancel');
                  if ($ps == 'verified')
                    echo '<a class="b sv" href="../../frontend/receipt.php?id=' . $x['id'] . '" target="_blank">Receipt</a>'; ?>
                </div>
              </td>
            </tr><?php endforeach;
          if (!$r)
            echo '<tr><td colspan="7">No reservations here yet.</td></tr>'; ?>
        </table>
      </div>
    <?php elseif ($p == 'cot'):
      $cs = $pdo->query('SELECT * FROM cottages ORDER BY cottage_no')->fetchAll();
      $AM = ['Table', 'Benches', 'Shaded roof', 'Spot light', 'Electric fan', 'Near the beach', 'Videoke', 'Grill area']; ?>
      <h2>Cottages</h2>
      <p class="hi"><?= count($cs) ?> cottages · overnight price = day price × <?= $m ?></p>
      <details class="addbtn" <?= isset($_GET['add']) ? 'open' : '' ?>>
        <summary>＋ Add new cottage</summary>
        <div class="box">
          <form method="post" enctype="multipart/form-data"><input type="hidden" name="a" value="add">
            <div class="grid2">
              <div><label for="n">Cottage name</label><input id="n" name="name" required placeholder="e.g. Cottage 8">
              </div>
              <div><label for="pr">Day price (₱)</label><input id="pr" type="number" name="price" value="300" min="0"
                  required></div>
              <div><label for="cp">Capacity (people)</label><input id="cp" type="number" name="capacity" value="15"
                  min="1" required></div>
            </div>
            <label for="ds">Description</label><input id="ds" name="description"
              placeholder="A short sentence about this cottage">
            <label>Picture</label>
            <div class="up"><img id="pv" alt=""
                src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="><input type="file"
                name="image" accept="image/*" onchange="if(this.files[0])pv.src=URL.createObjectURL(this.files[0])"></div>
            <label>Amenities (tap to choose)</label>
            <div class="chips">
              <?php foreach ($AM as $x)
                echo '<label class="chip"><input type="checkbox" name="am[]" value="' . e($x) . '"><span>' . e($x) . '</span></label>'; ?>
            </div>
            <label for="ot">Other amenities (separate with commas)</label><input id="ot" name="other"
              placeholder="Hammock, Mini bar">
            <div class="row" style="margin-top:1.2rem"><button class="b sv">Add cottage</button></div>
          </form>
        </div>
      </details>
      <div class="cgrid"><?php foreach ($cs as $x): ?>
          <div class="cc"><img src="<?= e(cimg($x, '../../frontend/')) ?>" alt="<?= e(cname($x)) ?>">
            <div class="in">
              <h3><?= e(cname($x)) ?> <span
                  class="pill <?= $x['status'] == 'available' ? 'approved' : 'rejected' ?>"><?= $x['status'] == 'available' ? 'Available' : 'Maintenance' ?></span>
              </h3>
              <div class="pr">₱<?= number_format($x['price']) ?> day · ₱<?= number_format($x['price'] * $m) ?> overnight
              </div><small>Up to <?= $x['capacity'] ?> people</small>
              <div class="tags" style="margin-top:.5rem"><?php foreach (array_filter(array_map('trim', explode(',', $x['amenities']))) as $t)
                echo '<span>' . e($t) . '</span>'; ?></div>
            </div>
            <details>
              <summary>Edit details</summary>
              <form method="post" enctype="multipart/form-data"><input type="hidden" name="a" value="edit"><input
                  type="hidden" name="id" value="<?= $x['id'] ?>">
                <label>Name<input name="name" value="<?= e(cname($x)) ?>"></label>
                <div class="grid2"><label>Day price (₱)<input type="number" name="price"
                      value="<?= $x['price'] ?>"></label><label>Capacity<input type="number" name="capacity"
                      value="<?= $x['capacity'] ?>"></label></div>
                <label>Status<select name="cs">
                    <option value="available">Available</option>
                    <option value="maintenance" <?= $x['status'] == 'maintenance' ? 'selected' : '' ?>>Maintenance</option>
                  </select></label>
                <label>Description<input name="description" value="<?= e($x['description']) ?>"></label><label>Amenities
                  (comma separated)<input name="amenities" value="<?= e($x['amenities']) ?>"></label><label>Change
                  picture<input type="file" name="image" accept="image/*"></label>
                <div class="row" style="margin-top:.8rem"><button class="b sv">Save changes</button><button class="b no"
                    name="a" value="del" onclick="return confirm('Delete this cottage?')">Delete</button></div>
              </form>
            </details>
          </div><?php endforeach; ?>
      </div>
    <?php else: ?>
      <h2>Settings</h2>
      <div class="panel">
        <form method="post"><input type="hidden" name="a" value="set">
          <div class="grid2"><?php foreach (['entrance_fee' => 'Entrance fee (₱ per person)', 'overnight_multiplier' => 'Overnight multiplier (2 = double)', 'contact_number' => 'Contact number', 'email' => 'Email', 'maps_url' => 'Google Maps link', 'ewallet_name' => 'E-wallet name (GCash, Maya…)', 'ewallet_number' => 'E-wallet number', 'ewallet_holder' => 'E-wallet account name'] as $k => $l)
            echo "<label>$l<input name='$k' value='" . e(setting($k)) . "'></label>"; ?></div><br><button class="b sv"
            style="padding:.6rem 1.4rem">Save changes</button>
        </form>
      </div><?php endif; ?>
  </main>
  <script src="../../frontend/js/resize.js"></script>
</body>

</html>
