<?php
session_start();
require_once "../includes/db.php";

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    // Admins go to admin page
    if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
        header("Location: ../admin.php");
    } else {
        header("Location: ../index.php");
    }
    exit;
}

$error = "";

// Debug mode - remove in production
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Trim and lowercase email
    $email = strtolower(trim($_POST['email']));
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        $error = "Please fill in all fields.";
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE LOWER(email) = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if (!$user) {
            $error = "Invalid email or password.";
        } elseif (!password_verify($password, $user['password_hash'])) {
            $error = "Invalid email or password.";
        } elseif (isset($user['is_suspended']) && $user['is_suspended'] == 1) {
            $error = "Your account has been suspended.";
        } else {
            // SUCCESS
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['full_name'] = $user['full_name'];

            // Handle roles (user vs admin)
            if (isset($user['role']) && $user['role'] === 'admin') {
                $_SESSION['role'] = 'admin';
                header("Location: ../admin.php");
            } else {
                $_SESSION['role'] = 'user';
                header("Location: ../index.php");
            }
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login | Swap & Save</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="auth-body">

<div class="auth-container">

    <!-- LEFT SIDE -->
    <div class="auth-left">
        <h1>Buy, Sell & Swap<br><span>Sustainably</span></h1>
        <p>
            Join your campus community in reducing waste and
            saving money through sustainable shopping.
        </p>

        <div class="stats">
            <div class="stat">12.5T<br><small>CO₂ Saved</small></div>
            <div class="stat">1.2K<br><small>Students</small></div>
            <div class="stat">5.8K<br><small>Items Listed</small></div>
        </div>
    </div>

    <!-- RIGHT SIDE -->
    <div class="auth-right">
        <h2>Welcome Back</h2>
        <p>Login to continue your sustainable journey</p>

        <?php if (!empty($error)): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form action="" method="POST">
            <input type="email" name="email" placeholder="Email" required value="<?= isset($email) ? htmlspecialchars($email) : '' ?>">
            <input type="password" name="password" placeholder="Password" required>

            <div class="forgot">
                <a href="forgot.php">Forgot password?</a>
            </div>

            <button type="submit">Login</button>
        </form>

        <p class="switch">
            Don’t have an account?
            <a href="register.php">Sign up</a>
        </p>
    </div>

</div>

</body>
</html>
