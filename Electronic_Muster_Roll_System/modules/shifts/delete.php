<?php
include_once '../../includes/db.php';
require_once '../../includes/auth_check.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("DELETE FROM shifts WHERE id = ?");
$stmt->execute([$id]);

header("Location: index.php");
exit;
