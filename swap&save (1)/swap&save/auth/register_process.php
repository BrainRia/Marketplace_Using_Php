<?php
session_start();
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Invalid request");
}

$full_name = $_POST['name'] ?? '';
$email     = $_POST['email'] ?? '';
$password  = $_POST['password'] ?? '';
$confirm   = $_POST['confirm'] ?? '';

if ($password !== $confirm) {
    die("Passwords do not match");
}

$hash = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare(
    "INSERT INTO users (full_name, email, password_hash)
     VALUES (?, ?, ?)"
);

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("sss", $full_name, $email, $hash);

if (!$stmt->execute()) {
    die("Execute failed: " . $stmt->error);
}

$_SESSION['user_id'] = $conn->insert_id;

header("Location: ../index.php");
exit;
