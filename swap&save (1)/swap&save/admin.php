<?php
session_start();
require_once "includes/db.php";

if ($_SESSION['role'] !== 'admin') {
    exit("Access denied");
}

if (isset($_POST['suspend'])) {
    $uid = intval($_POST['user_id']);
    $conn->query("UPDATE users SET is_suspended = 1 WHERE id = $uid");
}

if (isset($_POST['unsuspend'])) {
    $uid = intval($_POST['user_id']);
    $conn->query("UPDATE users SET is_suspended = 0 WHERE id = $uid");
}

$users = $conn->query("SELECT * FROM users");
?>

<h2>Admin Panel</h2>

<table>
<tr>
    <th>User</th>
    <th>Status</th>
    <th>Action</th>
</tr>

<?php while ($u = $users->fetch_assoc()): ?>
<tr>
    <td><?= htmlspecialchars($u['full_name']) ?></td>
    <td><?= $u['is_suspended'] ? "Suspended" : "Active" ?></td>
    <td>
        <?php if ($u['is_suspended']): ?>
            <form method="POST">
                <input type="hidden" name="user_id" value="<?= $u['id'] ?>">
                <button name="unsuspend">Unsuspend</button>
            </form>
        <?php else: ?>
            <form method="POST">
                <input type="hidden" name="user_id" value="<?= $u['id'] ?>">
                <button name="suspend">Suspend</button>
            </form>
        <?php endif; ?>
    </td>
</tr>
<?php endwhile; ?>
</table>
