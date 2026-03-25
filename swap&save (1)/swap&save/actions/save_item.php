<?php
session_start();
include '../includes/db.php';

/* DEBUG (remove later if you want) */
error_reporting(E_ALL);
ini_set('display_errors', 1);

/* Auth check */
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    die("Not logged in");
}

/* Collect form data */
$user_id         = $_SESSION['user_id'];
$title           = trim($_POST['title'] ?? '');
$description     = trim($_POST['description'] ?? '');
$price           = floatval($_POST['price'] ?? 0);
$weight_kg       = floatval($_POST['weight_kg'] ?? 0);
$category_id     = intval($_POST['category_id'] ?? 0);
$item_condition  = trim($_POST['item_condition'] ?? '');
$pickup_location = trim($_POST['pickup_location'] ?? '');

/* Basic validation */
if (
    $title === '' ||
    $description === '' ||
    $price <= 0 ||
    $weight_kg <= 0 ||
    $category_id <= 0 ||
    $item_condition === '' ||
    $pickup_location === ''
) {
    die("Validation error: missing required fields");
}

/* =========================
   IMAGE UPLOAD
   ========================= */
$imagePath = null;

if (!empty($_FILES['image']['name'])) {

    $targetDir = "../uploads/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'webp'];

    if (!in_array($ext, $allowed)) {
        die("Invalid image type");
    }

    $filename = time() . "_" . uniqid() . "." . $ext;
    $targetFile = $targetDir . $filename;

    if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
        die("Failed to upload image");
    }

    /* Save relative path for frontend */
    $imagePath = "uploads/" . $filename;
}

/* =========================
   INSERT INTO DATABASE
   ========================= */
$stmt = $conn->prepare("
    INSERT INTO items
    (
        user_id,
        title,
        description,
        price,
        weight_kg,
        category_id,
        item_condition,
        pickup_location,
        image
    )
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
");

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param(
    "issddisss",
    $user_id,
    $title,
    $description,
    $price,
    $weight_kg,
    $category_id,
    $item_condition,
    $pickup_location,
    $imagePath
);

if ($stmt->execute()) {
    echo "success";
} else {
    echo "DB Error: " . $stmt->error;
}
