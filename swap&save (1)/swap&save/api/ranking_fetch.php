<?php
session_start();
include '../includes/db.php';

$userId = $_SESSION['user_id'];

/* Total users */
$totalUsers = $conn->query("SELECT COUNT(*) total FROM users")
                   ->fetch_assoc()['total'];

/* User rank */
$stmt = $conn->prepare("
    SELECT COUNT(*) + 1 AS user_rank
    FROM (
        SELECT
            u.id,
            SUM(i.weight_kg * f.co2_per_kg) AS total_co2
        FROM users u
        LEFT JOIN items i ON u.id = i.user_id
        LEFT JOIN impact_factors f ON i.category_id = f.category_id
        GROUP BY u.id
    ) ranked
    WHERE total_co2 > (
        SELECT
            SUM(i.weight_kg * f.co2_per_kg)
        FROM items i
        JOIN impact_factors f ON i.category_id = f.category_id
        WHERE i.user_id = ?
    )
");

$stmt->bind_param("i", $userId);
$stmt->execute();
$rank = $stmt->get_result()->fetch_assoc()['user_rank'];

$aheadOf = $totalUsers - $rank;
$percentile = round((1 - ($rank / $totalUsers)) * 100);

echo json_encode([
    "rank" => $rank,
    "total" => $totalUsers,
    "ahead" => $aheadOf,
    "percentile" => $percentile
]);
