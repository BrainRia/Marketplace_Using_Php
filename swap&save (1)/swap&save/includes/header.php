<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Swap & Save</title>

    <link rel="stylesheet" href="/Swap&Save/assets/css/style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>

<body>

<nav class="navbar">
    <!-- LEFT -->
    <div class="nav-left">
        <span class="logo-text">Swap & Save</span>
    </div>

    <!-- CENTER -->
    <div class="nav-center">
        <a href="/Swap&Save/index.php" class="nav-link active">Marketplace</a>
        <a href="/Swap&Save/impact.php" class="nav-link">My Impact</a>
    </div>

    <!-- RIGHT -->
    <div class="nav-right">
        <a href="#" id="addItemBtn" class="list-item-btn">+ List Item</a>
        <a href="/Swap&Save/auth/logout.php" class="logout-btn">Logout</a>
    </div>
</nav>
