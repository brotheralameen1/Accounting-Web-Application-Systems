<?php
include_once '../../includes/db.php';
include_once '../../includes/header.php';
require_once '../../includes/auth_check.php';

$stmt = $pdo->query("SELECT * FROM designations ORDER BY id DESC");
?>

<div class="container">
    <h2>Designations</h2>
    <a href="add.php">+ Add Designation</a>
    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Base Wage (Tsh)</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $stmt->fetch()) : ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['title']) ?></td>
                <td><?= number_format($row['base_wage'], 2) ?></td>
                <td>
                    <a href="edit.php?id=<?= $row['id'] ?>">Edit</a> | 
                    <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this designation?');">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include_once '../../includes/footer.php'; ?>
