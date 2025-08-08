<?php
include_once '../../includes/db.php';
include_once '../../includes/header.php';
require_once '../../includes/auth_check.php';

$date = $_GET['date'] ?? date('Y-m-d');

// Fetch attendance with employee, shift, designation info
$stmt = $pdo->prepare("
    SELECT a.*, e.name AS employee_name, d.title AS designation_title, s.name AS shift_name
    FROM attendance a
    LEFT JOIN employees e ON a.employee_id = e.id
    LEFT JOIN designations d ON a.designation_id = d.id
    LEFT JOIN shifts s ON a.shift_id = s.id
    WHERE a.attendance_date = ?
    ORDER BY e.name ASC
");
$stmt->execute([$date]);
$attendanceRecords = $stmt->fetchAll();

// Fetch loans taken on this day per employee
$loanStmt = $pdo->prepare("
    SELECT employee_id, SUM(amount) AS total_loans
    FROM loans
    WHERE loan_date = ?
    GROUP BY employee_id
");
$loanStmt->execute([$date]);
$loans = [];
foreach ($loanStmt->fetchAll() as $row) {
    $loans[$row['employee_id']] = $row['total_loans'];
}
?>

<div class="container">
    <h2>Daily Activity Report — <?= htmlspecialchars($date) ?></h2>

    <form method="get">
        <label>Select Date:</label>
        <input type="date" name="date" value="<?= $date ?>" onchange="this.form.submit()">
    </form>

    <table border="1" cellpadding="8" cellspacing="0" style="width:100%; margin-top: 1rem;">
        <thead>
            <tr>
                <th>Employee</th>
                <th>Designation</th>
                <th>Shift</th>
                <th>Task Note</th>
                <th>Daily Wage (Tsh)</th>
                <th>Loan Deducted (Tsh)</th>
                <th>Net Wage (Tsh)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($attendanceRecords as $rec): 
                $loanAmt = $loans[$rec['employee_id']] ?? 0;
                $netWage = $rec['wage'] - $loanAmt;
            ?>
            <tr>
                <td><?= htmlspecialchars($rec['employee_name']) ?></td>
                <td><?= htmlspecialchars($rec['designation_title']) ?></td>
                <td><?= htmlspecialchars($rec['shift_name']) ?></td>
                <td><?= nl2br(htmlspecialchars($rec['task_note'])) ?></td>
                <td><?= number_format($rec['wage'], 2) ?></td>
                <td><?= number_format($loanAmt, 2) ?></td>
                <td><?= number_format($netWage, 2) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include_once '../../includes/footer.php'; ?>
