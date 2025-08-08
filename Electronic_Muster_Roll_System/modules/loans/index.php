<?php
include_once '../../includes/db.php';
include_once '../../includes/header.php';
require_once '../../includes/auth_check.php';

$stmt = $pdo->query("
    SELECT loans.*, employees.name AS employee 
    FROM loans 
    JOIN employees ON loans.employee_id = employees.id
    ORDER BY loan_date DESC, id DESC
");
?>

<div class="container">
    <h2>Loans</h2>
    <a href="add.php">+ Add Loan</a>
    <table border="1" cellpadding="8" cellspacing="0" style="width:100%;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Employee</th>
                <th>Amount (Tsh)</th>
                <th>Reason</th>
                <th>Loan Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($loan = $stmt->fetch()) : ?>
            <tr>
                <td><?= $loan['id'] ?></td>
                <td><?= htmlspecialchars($loan['employee']) ?></td>
                <td><?= number_format($loan['amount'], 2) ?></td>
                <td><?= nl2br(htmlspecialchars($loan['reason'])) ?></td>
                <td><?= $loan['loan_date'] ?></td>
                <td>
                    <a href="edit.php?id=<?= $loan['id'] ?>">Edit</a> | 
                    <a href="delete.php?id=<?= $loan['id'] ?>" onclick="return confirm('Delete this loan?');">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include_once '../../includes/footer.php'; ?>
