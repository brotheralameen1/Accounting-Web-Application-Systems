<?php
include_once '../../includes/db.php';
include_once '../../includes/header.php';
require_once '../../includes/auth_check.php';

$employees = $pdo->query("SELECT * FROM employees ORDER BY name ASC")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employee_id = $_POST['employee_id'];
    $amount = $_POST['amount'];
    $reason = $_POST['reason'];
    $loan_date = $_POST['loan_date'];

    $stmt = $pdo->prepare("INSERT INTO loans (employee_id, amount, reason, loan_date) VALUES (?, ?, ?, ?)");
    $stmt->execute([$employee_id, $amount, $reason, $loan_date]);

    header("Location: index.php");
    exit;
}
?>

<div class="container">
    <h2>Add Loan</h2>
    <form method="POST">
        <label>Employee:</label><br>
        <select name="employee_id" required>
            <option value="">-- Select Employee --</option>
            <?php foreach ($employees as $emp) : ?>
                <option value="<?= $emp['id'] ?>"><?= htmlspecialchars($emp['name']) ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label>Amount (Tsh):</label><br>
        <input type="number" step="0.01" name="amount" required><br><br>

        <label>Reason:</label><br>
        <textarea name="reason" rows="4"></textarea><br><br>

        <label>Loan Date:</label><br>
        <input type="date" name="loan_date" value="<?= date('Y-m-d') ?>" required><br><br>

        <button type="submit">Add Loan</button>
    </form>
</div>

<?php include_once '../../includes/footer.php'; ?>
