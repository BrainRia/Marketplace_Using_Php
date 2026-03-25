<!DOCTYPE html>
<html>
<head>
  <title>Forgot Password</title>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="auth-body">
<div class="auth-container">
  <div class="auth-right">
    <h2>Reset Password</h2>
    <form action="forgot_process.php" method="POST">
      <input type="email" name="email" placeholder="Your email" required>
      <button type="submit">Send Reset Link</button>
    </form>
  </div>
</div>
</body>
</html>
