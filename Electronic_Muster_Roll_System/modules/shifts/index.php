<?php
include_once '../../includes/db.php';
include_once '../../includes/header.php';
require_once '../../includes/auth_check.php';

$stmt = $pdo->query("SELECT shifts.*, designations.title AS designation FROM shifts 
                     LEFT JOIN designations ON shifts.designation_id = designations.id 
                     ORDER BY shifts.id DESC");
?>

<div class="container">
    <h2>Shifts</h2>
    <a href="add.php">+ Add Shift</a>
    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Shift Name</th>
                <th>Designation</th>
                <th>Has Time?</th>
                <th>Start</th>
                <th>End</th>
                <th>Wage (Tsh)</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $stmt->fetch()) : ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['designation']) ?></td>
                <td><?= $row['has_time'] ? 'Yes' : 'No' ?></td>
                <td><?= $row['has_time'] ? $row['start_time'] : '-' ?></td>
                <td><?= $row['has_time'] ? $row['end_time'] : '-' ?></td>
                <td><?= number_format($row['wage_per_day'], 2) ?></td>
                <td>
                    <a href="edit.php?id=<?= $row['id'] ?>">Edit</a> |
                    <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete shift?');">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include_once '../../includes/footer.php'; ?>
