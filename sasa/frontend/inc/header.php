<?php require_once __DIR__ . '/../../backend/config.php';
$base = $base ?? ''; ?><!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title><?= e($title ?? 'Sasa Beach Resort') ?></title>
	<link
		href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@600;800&family=Nunito+Sans:wght@400;600&display=swap"
		rel="stylesheet">
	<link rel="stylesheet" href="<?= $base ?>css/style.css">
</head>

<body>
	<header class="nav"><a class="brand" href="index.php">Sasa Beach</a><input type="checkbox" id="m"><label for="m"
			class="burger">Menu</label>
		<nav>
			<a href="index.php">Home</a><a href="index.php#about">About</a><a href="cottages.php">Cottages &amp; Rates</a><a
				href="cottages.php#choose">Reservation</a><a href="index.php#gallery">Gallery</a><a
				href="index.php#rules">Rules</a><a href="index.php#location">Location</a><a href="index.php#contact">Contact</a>
		</nav>
	</header>