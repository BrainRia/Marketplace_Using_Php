<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sign Up | Swap & Save</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="auth-body">

<div class="auth-container">

    <!-- LEFT SIDE -->
    <div class="auth-left">
        <h1>Join the<br><span>Swap & Save</span></h1>
        <p>
            Create an account to start buying, selling,
            and swapping items sustainably on your campus.
        </p>
    </div>

    <!-- RIGHT SIDE -->
    <div class="auth-right">
        <h2>Create Account</h2>
        <p>Sign up to begin your sustainable journey</p>

        <?php if (isset($_GET['error'])): ?>
            <div class="error"><?= htmlspecialchars($_GET['error']) ?></div>
        <?php endif; ?>

        <form action="register_process.php" method="POST">
    <input name="name" required>
    <input name="email" type="email" required>
    <input name="password" type="password" required>
    <input name="confirm" type="password" required>
    <button type="submit">Register</button>
</form>


        <p class="switch">
            Already have an account?
            <a href="login.php">Login</a>
        </p>
    </div>

</div>

</body>
</html>
