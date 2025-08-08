<?php
include_once '../../includes/db.php';
require_once '../../includes/auth_check.php';

$id = $_GET['id'];
$date = $_GET['date'] ?? date('Y-m-d');

$stmt = $pdo->prepare("DELETE FROM attendance WHERE id = ?");
$stmt->execute([$id]);

header("Location: index.php?date=$date");
exit;
