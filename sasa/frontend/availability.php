<?php require __DIR__.'/../backend/config.php';header('Content-Type: application/json');
$d=$_GET['date']??'';$t=$_GET['type']??'';echo json_encode(preg_match('/^\d{4}-\d\d-\d\d$/',$d)&&in_array($t,['day','overnight'])?booked_ids($d,$t):[]);
