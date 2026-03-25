<?php
include '../includes/db.php';

$id = intval($_GET['id']);

$sql = "
SELECT
    i.title,
    i.description,
    i.price,
    i.weight_kg,
    i.image,
    i.pickup_location,
    f.co2_per_kg,
    f.water_per_kg,
    f.waste_per_kg,
    COALESCE(f.energy_per_kg, 0) AS energy_per_kg
FROM items i
LEFT JOIN impact_factors f ON i.category_id = f.category_id
WHERE i.id = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$item = $stmt->get_result()->fetch_assoc();

if (!$item) {
    http_response_code(404);
    exit;
}

$weight = (float)$item['weight_kg'];

$response = [
    "title"            => $item['title'],
    "description"      => $item['description'],
    "price"            => $item['price'],
    "image"            => $item['image'],
    "pickup_location"  => $item['pickup_location'],

    /* Environmental impact */
    "co2_saved"        => $weight * (float)$item['co2_per_kg'],
    "water_saved"      => $weight * (float)$item['water_per_kg'],
    "waste_saved"      => $weight * (float)$item['waste_per_kg'],
    "energy_saved"     => $weight * (float)$item['energy_per_kg']
];

header("Content-Type: application/json");
echo json_encode($response);
