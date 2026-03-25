<?php
session_start();
require_once "../includes/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$item_id = intval($_POST['item_id']);

$stmt = $conn->prepare("
    UPDATE items
    SET status = 'in_progress', buyer_id = ?
    WHERE id = ? AND status = 'available'
");
$stmt->bind_param("ii", $user_id, $item_id);
$stmt->execute();

header("Location: ../index.php");
exit;
