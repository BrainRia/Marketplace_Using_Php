<?php
include '../includes/db.php';

$id = $_GET['id'];

$stmt = $conn->prepare("
    SELECT 
        i.title, i.description, i.weight_kg, i.price, i.image,
        c.name AS category,
        (i.weight_kg * f.co2_per_kg) AS co2_saved,
        (i.weight_kg * f.water_per_kg) AS water_saved,
        (i.weight_kg * f.waste_per_kg) AS waste_saved
    FROM items i
    JOIN categories c ON i.category_id = c.id
    JOIN impact_factors f ON c.id = f.category_id
    WHERE i.id = ?
");

$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

echo json_encode($result->fetch_assoc());
