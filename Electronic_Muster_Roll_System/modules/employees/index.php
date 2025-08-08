<?php
include_once '../../includes/db.php';
include_once '../../includes/header.php';
require_once '../../includes/auth_check.php';

$stmt = $pdo->query("SELECT * FROM employees ORDER BY id DESC");
?>

<div class="container">
    <h2>Employees</h2>
    <a href="add.php">+ Add Employee</a>
    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Created</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $stmt->fetch()) : ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['phone']) ?></td>
                <td><?= $row['created_at'] ?></td>
                <td>
                    <a href="edit.php?id=<?= $row['id'] ?>">Edit</a> | 
                    <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete employee?');">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include_once '../../includes/footer.php'; ?>
