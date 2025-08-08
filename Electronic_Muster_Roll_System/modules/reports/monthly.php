<?php
include_once '../../includes/db.php';
include_once '../../includes/header.php';
require_once '../../includes/auth_check.php';

// Fiscal month: from 18th of previous month to 17th of current month if no date param
if (isset($_GET['year']) && isset($_GET['month'])) {
    $year = intval($_GET['year']);
    $month = intval($_GET['month']);
} else {
    // Default to current fiscal month
    $today = new DateTime();
    $day = intval($today->format('d'));
    $year = intval($today->format('Y'));
    $month = intval($today->format('m'));

    if ($day < 18) {
        // Use previous month for fiscal start
        $month--;
        if ($month < 1) {
            $month = 12;
            $year--;
        }
    }
}

$fiscal_start = new DateTime("$year-$month-18");
$fiscal_end = clone $fiscal_start;
$fiscal_end->modify('+1 month')->modify('-1 day'); // 17th of next month

// Fetch employees
$employees = $pdo->query("SELECT * FROM employees ORDER BY name ASC")->fetchAll();

?>

<div class="container">
    <h2>Monthly Payroll Report</h2>
    <form method="get" style="margin-bottom: 1rem;">
        <label for="year">Year:</label>
        <input type="number" name="year" value="<?= $fiscal_start->format('Y') ?>" required min="2000" max="2100" style="width:80px;">
        <label for="month">Month:</label>
        <input type="number" name="month" value="<?= $fiscal_start->format('m') ?>" required min="1" max="12" style="width:50px;">
        <button type="submit">View</button>
    </form>

    <p>Fiscal month: <strong><?= $fiscal_start->format('Y-m-d') ?></strong> to <strong><?= $fiscal_end->format('Y-m-d') ?></strong></p>

    <table border="1" cellpadding="8" cellspacing="0" style="width:100%;">
        <thead>
            <tr>
                <th>Employee</th>
                <th>Total Wages (Tsh)</th>
                <th>Total Loans (Tsh)</th>
                <th>Net Salary (Tsh)</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($employees as $emp): 
            // Sum wages for fiscal month
            $wageStmt = $pdo->prepare("
                SELECT SUM(wage) FROM attendance 
                WHERE employee_id = ? AND attendance_date BETWEEN ? AND ?
            ");
            $wageStmt->execute([$emp['id'], $fiscal_start->format('Y-m-d'), $fiscal_end->format('Y-m-d')]);
            $totalWages = $wageStmt->fetchColumn() ?? 0;

            // Sum loans for fiscal month
            $loanStmt = $pdo->prepare("
                SELECT SUM(amount) FROM loans
                WHERE employee_id = ? AND loan_date BETWEEN ? AND ?
            ");
            $loanStmt->execute([$emp['id'], $fiscal_start->format('Y-m-d'), $fiscal_end->format('Y-m-d')]);
            $totalLoans = $loanStmt->fetchColumn() ?? 0;

            $netSalary = $totalWages - $totalLoans;
        ?>
            <tr>
                <td><?= htmlspecialchars($emp['name']) ?></td>
                <td><?= number_format($totalWages, 2) ?></td>
                <td><?= number_format($totalLoans, 2) ?></td>
                <td><?= number_format($netSalary, 2) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include_once '../../includes/footer.php'; ?>
