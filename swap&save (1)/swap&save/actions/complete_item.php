<?php
session_start();
require_once "../includes/db.php";

if (!isset($_SESSION['user_id'])) {
    exit;
}

$user_id = $_SESSION['user_id'];
$item_id = intval($_POST['item_id']);

$stmt = $conn->prepare("
    UPDATE items
    SET status = 'completed', completed_at = NOW()
    WHERE id = ? AND user_id = ? AND status = 'in_progress'
");
$stmt->bind_param("ii", $item_id, $user_id);
$stmt->execute();

header("Location: ../index.php");
exit;
