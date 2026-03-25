<?php
session_start();
require_once "includes/db.php";

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch all categories
$categories_sql = "SELECT id, name FROM categories";
$categories_result = $conn->query($categories_sql);

$categories = [];
$category_ids = [];
while ($cat = $categories_result->fetch_assoc()) {
    $categories[] = $cat['name'];
    $category_ids[] = $cat['id'];
}

// Fetch impact for completed items per user
$impact_data = [];
foreach ($category_ids as $cat_id) {
    $sql = "
        SELECT 
            SUM(i.weight_kg * f.co2_per_kg) AS co2,
            SUM(i.weight_kg * f.water_per_kg) AS water,
            SUM(i.weight_kg * f.waste_per_kg) AS waste,
            SUM(i.weight_kg * f.energy_per_kg) AS energy
        FROM items i
        JOIN impact_factors f ON f.category_id = i.category_id
        WHERE i.status = 'completed' AND i.category_id = ? AND i.user_id = ?
    ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $cat_id, $user_id);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();

    $impact_data[] = [
        'co2' => round($res['co2'] ?? 0, 2),
        'water' => round($res['water'] ?? 0, 2),
        'waste' => round($res['waste'] ?? 0, 2),
        'energy' => round($res['energy'] ?? 0, 2)
    ];
}

// Prepare separate arrays for Chart.js
$co2 = array_column($impact_data, 'co2');
$water = array_column($impact_data, 'water');
$waste = array_column($impact_data, 'waste');
$energy = array_column($impact_data, 'energy');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Impact | Swap & Save</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f9; margin: 0; padding: 0; }
        .container { max-width: 900px; margin: 50px auto; text-align: center; background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        h1 { margin-bottom: 10px; color: #333; }
        p.description { margin-bottom: 30px; color: #666; }
        canvas { margin-top: 20px; }
    </style>
</head>
<body>

<div class="container">
    <h1>Impact Results</h1>
    <p class="description">
        This chart shows the environmental impact of your completed transactions per category.<br>
        Metrics include CO₂ saved (kg), Water saved (L), Waste prevented (kg), and Energy saved (kWh).
    </p>

    <canvas id="impactChart"></canvas>
</div>

<script>
const ctx = document.getElementById('impactChart').getContext('2d');

const impactChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?= json_encode($categories) ?>,
        datasets: [
            {
                label: 'CO₂ Saved (kg)',
                data: <?= json_encode($co2) ?>,
                backgroundColor: 'rgba(255, 99, 132, 0.7)'
            },
            {
                label: 'Water Saved (L)',
                data: <?= json_encode($water) ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.7)'
            },
            {
                label: 'Waste Prevented (kg)',
                data: <?= json_encode($waste) ?>,
                backgroundColor: 'rgba(255, 206, 86, 0.7)'
            },
            {
                label: 'Energy Saved (kWh)',
                data: <?= json_encode($energy) ?>,
                backgroundColor: 'rgba(75, 192, 192, 0.7)'
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'top' },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return context.dataset.label + ': ' + context.parsed.y;
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                title: { display: true, text: 'Impact Value' }
            },
            x: {
                title: { display: true, text: 'Category' }
            }
        }
    }
});
</script>

</body>
</html>
