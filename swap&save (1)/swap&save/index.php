<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit;
}

include 'includes/db.php';
include 'includes/header.php';

$sql = "
SELECT i.*, c.name AS category
FROM items i
LEFT JOIN categories c ON i.category_id = c.id
WHERE i.status != 'completed'
ORDER BY i.created_at DESC
";
$result = $conn->query($sql);

// Fetch categories dynamically
$categories_sql = "SELECT name FROM categories";
$categories_result = $conn->query($categories_sql);
$all_categories = ['All'];
while ($cat = $categories_result->fetch_assoc()) {
    $all_categories[] = $cat['name'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Marketplace | Swap & Save</title>
    <link rel="stylesheet" href="/Swap&Save/assets/css/style.css">
    <style>
        .filters { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 20px; justify-content: center; }
        .filters input.search { padding: 8px 12px; width: 250px; border-radius: 5px; border: 1px solid #ccc; }
        .categories button { padding: 6px 12px; border: none; border-radius: 5px; cursor: pointer; background: #eee; transition: 0.2s; }
        .categories button.active, .categories button:hover { background: #4caf50; color: #fff; }
  /
    </style>
</head>

<body>

<div class="container">

    <!-- Search & Filters -->
    <div class="filters">
        <input type="text" class="search" placeholder="Search for items...">

        <div class="categories">
            <?php foreach ($all_categories as $cat): ?>
                <button class="<?= $cat === 'All' ? 'active' : '' ?>"><?= htmlspecialchars($cat) ?></button>
            <?php endforeach; ?>
        </div>

    </div>

    <!-- Items -->
    <?php if ($result->num_rows === 0): ?>
        <p>No items listed yet.</p>
    <?php else: ?>
        <div class="items-grid">
            <?php while ($item = $result->fetch_assoc()): ?>
                <div class="item-card" data-id="<?= $item['id'] ?>" data-category="<?= htmlspecialchars($item['category']) ?>">

                    <div class="item-image">
                        <img
                            src="/Swap&Save/<?= $item['image'] ?: 'assets/img/placeholder.jpg' ?>"
                            alt="<?= htmlspecialchars($item['title']) ?>"
                        >
                    </div>

                    <div class="item-content">
                        <h3><?= htmlspecialchars($item['title']) ?></h3>
                        <p class="price">€<?= number_format($item['price'], 2) ?></p>

                        <!-- ITEM STATE LOGIC -->
                        <?php if ($item['status'] === 'available'): ?>
                            <?php if ($item['user_id'] != $_SESSION['user_id']): ?>
                                <form method="POST" action="actions/buy_item.php">
                                    <input type="hidden" name="item_id" value="<?= $item['id'] ?>">
                                    <button type="submit" class="btn-buy">Buy</button>
                                </form>
                            <?php endif; ?>
                        <?php elseif ($item['status'] === 'in_progress'): ?>
                            <?php if ($item['buyer_id'] == $_SESSION['user_id']): ?>
                                <span class="badge in-progress">In Progress</span>
                            <?php endif; ?>
                            <?php if ($item['user_id'] == $_SESSION['user_id']): ?>
                                <form method="POST" action="actions/complete_item.php">
                                    <input type="hidden" name="item_id" value="<?= $item['id'] ?>">
                                    <button type="submit" class="btn-complete">Complete</button>
                                </form>
                            <?php endif; ?>
                        <?php endif; ?>

                    </div>

                </div>
            <?php endwhile; ?>
        </div>
    <?php endif; ?>

</div>

<!-- MODALS -->
<?php include 'modals/item_form.php'; ?>
<?php include 'modals/item_details.php'; ?>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="/Swap&Save/assets/js/app.js"></script>
<script src="/Swap&Save/assets/js/items.js"></script>

<!-- Search + Category + List Item enhancements -->
<script>
$(document).ready(function() {
    // Search items by title
    $('.search').on('input', function() {
        const term = $(this).val().toLowerCase();
        $('.item-card').each(function() {
            const title = $(this).find('h3').text().toLowerCase();
            $(this).toggle(title.includes(term));
        });
    });

    // Category filter
    $('.categories button').on('click', function() {
        const category = $(this).text().toLowerCase();
        $('.categories button').removeClass('active');
        $(this).addClass('active');

        $('.item-card').each(function() {
            const itemCategory = $(this).data('category').toLowerCase();
            if (category === 'all') $(this).show();
            else $(this).toggle(itemCategory === category);
        });
    });

    // Open "List Item" modal
    $('#open-list-item').on('click', function() {
        $('#itemFormModal').show(); // uses your existing modal
    });

    // Close modal
    $('.modal .close').on('click', function() {
        $(this).closest('.modal').hide();
    });

    // Close modal when clicking outside
    $('.modal').on('click', function(e) {
        if (e.target === this) $(this).hide();
    });
});
</script>

<?php include 'includes/footer.php'; ?>
</body>
</html>
