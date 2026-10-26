<?php require '../config.php';
if ($pdo->query('SELECT COUNT(*) FROM admins')->fetchColumn() == 0)
	$pdo->prepare('INSERT INTO admins(username,password_hash) VALUES(?,?)')->execute(['admin', password_hash('admin123', PASSWORD_DEFAULT)]);
$err = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$s = $pdo->prepare('SELECT * FROM admins WHERE username=?');
	$s->execute([$_POST['u'] ?? '']);
	$a = $s->fetch();
	if ($a && password_verify($_POST['p'] ?? '', $a['password_hash'])) {
		session_regenerate_id(true);
		$_SESSION['admin'] = $a['id'];
		header('Location: index.php');
		exit;
	}
	$err = 'Wrong username or password.';
}
?><!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Admin login</title>
	<link
		href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@600;800&family=Nunito+Sans:wght@400;600&display=swap"
		rel="stylesheet">
	<link rel="stylesheet" href="../../frontend/css/style.css">
	<link rel="stylesheet" href="admin.css">
</head>

<body class="adm" style="background:linear-gradient(180deg,#f5b700,#8a5a00);display:block">
	<div class="center">
		<h2>Sasa Beach admin</h2>
		<p class="hi">Log in to manage reservations.</p><?php if ($err)
			echo '<p class="err">' . e($err) . '</p>'; ?>
		<form method="post"><label>Username<input name="u" required></label><label>Password<input type="password" name="p"
					required></label><br><button class="btn">Log in</button></form>
		<p><small>First login: admin / admin123. Change it after logging in.</small></p>
	</div>
</body>

</html>