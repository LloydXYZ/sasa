<?php
// auth/logout.php
require_once '../config/db.php';
startSession();
session_destroy();
header('Location: ' . BASE_URL . 'index.php');
exit;
?>
