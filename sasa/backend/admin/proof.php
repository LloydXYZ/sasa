<?php require '../config.php';
if (empty($_SESSION['admin']))
	exit('No access');
$s = $pdo->prepare('SELECT payment_proof FROM reservations WHERE id=?');
$s->execute([(int) ($_GET['id'] ?? 0)]);
$f = basename((string) $s->fetchColumn());
$p = __DIR__ . '/../uploads/proofs/' . $f;
if (!$f || !is_file($p))
	exit('No file');
$i = getimagesize($p);
header('Content-Type: ' . $i['mime']);
readfile($p);
