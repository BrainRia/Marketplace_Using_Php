<?php
include '../includes/db.php';
$token = $_GET['token'];
?>

<form action="reset_process.php" method="POST">
  <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
  <input type="password" name="password" placeholder="New password" required>
  <button type="submit">Update Password</button>
</form>
