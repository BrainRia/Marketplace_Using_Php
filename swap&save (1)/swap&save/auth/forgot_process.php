<?php
include '../includes/db.php';

$email = $_POST['email'];
$token = bin2hex(random_bytes(32));
$expires = date("Y-m-d H:i:s", strtotime("+1 hour"));

$stmt = $conn->prepare(
  "UPDATE users SET reset_token=?, reset_expires=? WHERE email=?"
);
$stmt->bind_param("sss", $token, $expires, $email);
$stmt->execute();

/* For uni/demo: show link directly */
echo "Reset link: <a href='reset.php?token=$token'>Reset Password</a>";
