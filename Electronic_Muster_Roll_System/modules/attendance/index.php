<?php
include_once '../../includes/db.php';
include_once '../../includes/header.php';
require_once '../../includes/auth_check.php';

$date = $_GET['date'] ?? date('Y-m-d');
$stmt = $pdo->prepare("
    SELECT a.*, e.name AS employee, d.title AS designation, s.name AS shift 
    FROM attendance a
    LEFT JOIN employees e ON a.employee_id = e.id
    LEFT JOIN designations d ON a.designation_id = d.id
    LEFT JOIN shifts s ON a.shift_id = s.id
    WHERE attendance_date = ?
    ORDER BY a.id DESC
");
$stmt->execute([$date]);
?>

<div class="container">
    <h2>Attendance - <?= htmlspecialchars($date) ?></h2>

    <form method="get">
        <label>Select Date:</label>
        <input type="date" name="date" value="<?= $date ?>" onchange="this.form.submit()">
    </form>

    <a href="add.php?date=<?= $date ?>">+ Add Attendance</a>

    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>Employee</th>
                <th>Designation</th>
                <th>Shift</th>
                <th>Task Note</th>
                <th>Wage (Tsh)</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $stmt->fetch()) : ?>
            <tr>
                <td><?= htmlspecialchars($row['employee']) ?></td>
                <td><?= htmlspecialchars($row['designation']) ?></td>
                <td><?= htmlspecialchars($row['shift']) ?></td>
                <td><?= htmlspecialchars($row['task_note']) ?></td>
                <td><?= number_format($row['wage'], 2) ?></td>
                <td>
                    <a href="delete.php?id=<?= $row['id'] ?>&date=<?= $date ?>" onclick="return confirm('Delete entry?');">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include_once '../../includes/footer.php'; ?>
