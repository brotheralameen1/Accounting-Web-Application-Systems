<?php
require_once '../../includes/db.php';
require_once '../../includes/header.php';

$selectedDate = $_GET['date'] ?? date('Y-m-d');

// Fetch all attendance for that day
$sql = "
    SELECT 
        COALESCE(d.title, s.name, 'N/A') AS description,
        COUNT(a.id) AS num_people,
        SUM(a.wage) AS total_amount
    FROM attendance a
    LEFT JOIN designations d ON a.designation_id = d.id
    LEFT JOIN shifts s ON a.shift_id = s.id
    WHERE a.attendance_date = ?
    GROUP BY description
    ORDER BY description
";
$stmt = $pdo->prepare($sql);
$stmt->execute([$selectedDate]);
$reportData = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Total wage amount
$totalAmount = 0;
foreach ($reportData as $row) {
    $totalAmount += $row['total_amount'];
}

// Loans for that day
$loanStmt = $pdo->prepare("
    SELECT SUM(amount) as total_loans 
    FROM loans 
    WHERE loan_date = ?
");
$loanStmt->execute([$selectedDate]);
$totalLoans = $loanStmt->fetchColumn() ?: 0;

// Previous day balance
$previousDate = date('Y-m-d', strtotime($selectedDate . ' -1 day'));
$prevStmt = $pdo->prepare("SELECT balance FROM balances WHERE report_date = ?");
$prevStmt->execute([$previousDate]);
$prevBalance = $prevStmt->fetchColumn() ?: 0;

// Final balance calculation
$todayBalance = ($totalAmount - $totalLoans) + $prevBalance;

// Store balance for today
$storeStmt = $pdo->prepare("INSERT INTO balances (report_date, balance) VALUES (?, ?) ON DUPLICATE KEY UPDATE balance = VALUES(balance)");
$storeStmt->execute([$selectedDate, $todayBalance]);
?>

<div class="container">
    <h2>Daily Salary Report - <?= date('d M, Y', strtotime($selectedDate)) ?></h2>

    <form method="get">
        <label for="date">Select Date:</label>
        <input type="date" name="date" value="<?= htmlspecialchars($selectedDate) ?>">
        <button type="submit">View</button>
    </form>

    <table class="salary-table">
        <thead>
            <tr>
                <th>Description</th>
                <th>No. of People</th>
                <th>Amount (Tsh)</th>
                <th>Loans (Tsh)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reportData as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['description']) ?></td>
                    <td><?= $row['num_people'] ?></td>
                    <td><?= number_format($row['total_amount']) ?>/=</td>
                    <td></td>
                </tr>
            <?php endforeach; ?>
            <tr class="totals">
                <td><strong>Totals</strong></td>
                <td></td>
                <td><strong><?= number_format($totalAmount) ?>/=</strong></td>
                <td><strong><?= number_format($totalLoans) ?>/=</strong></td>
            </tr>
            <tr class="balance-row">
                <td colspan="3"><strong>Balance (Amount - Loans + Prev. Balance)</strong></td>
                <td><strong><?= number_format($todayBalance) ?>/=</strong></td>
            </tr>
        </tbody>
    </table>
</div>

<link rel="stylesheet" href="../../includes/report-style.css">

<?php require_once '../../includes/footer.php'; ?>
