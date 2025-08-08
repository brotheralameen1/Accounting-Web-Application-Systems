<?php
include_once '../../includes/db.php';
include_once '../../includes/header.php';
require_once '../../includes/auth_check.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM loans WHERE id = ?");
$stmt->execute([$id]);
$loan = $stmt->fetch();

if (!$loan) {
    echo "Loan not found!";
    exit;
}

$employees = $pdo->query("SELECT * FROM employees ORDER BY name ASC")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employee_id = $_POST['employee_id'];
    $amount = $_POST['amount'];
    $reason = $_POST['reason'];
    $loan_date = $_POST['loan_date'];

    $stmt = $pdo->prepare("UPDATE loans SET employee_id = ?, amount = ?, reason = ?, loan_date = ? WHERE id = ?");
    $stmt->execute([$employee_id, $amount, $reason, $loan_date, $id]);

    header("Location: index.php");
    exit;
}
?>

<div class="container">
    <h2>Edit Loan</h2>
    <form method="POST">
        <label>Employee:</label><br>
        <select name="employee_id" required>
            <?php foreach ($employees as $emp) : ?>
                <option value="<?= $emp['id'] ?>" <?= $loan['employee_id'] == $emp['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($emp['name']) ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <label>Amount (Tsh):</label><br>
        <input type="number" step="0.01" name="amount" value="<?= $loan['amount'] ?>" required><br><br>

        <label>Reason:</label><br>
        <textarea name="reason" rows="4"><?= htmlspecialchars($loan['reason']) ?></textarea><br><br>

        <label>Loan Date:</label><br>
        <input type="date" name="loan_date" value="<?= $loan['loan_date'] ?>" required><br><br>

        <button type="submit">Update Loan</button>
    </form>
</div>

<?php include_once '../../includes/footer.php'; ?>
