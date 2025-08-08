<?php
include_once '../../includes/db.php';
include_once '../../includes/header.php';
require_once '../../includes/auth_check.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $base_wage = $_POST['base_wage'];

    $stmt = $pdo->prepare("INSERT INTO designations (title, base_wage) VALUES (?, ?)");
    $stmt->execute([$title, $base_wage]);

    header("Location: index.php");
    exit;
}
?>

<div class="container">
    <h2>Add Designation</h2>
    <form method="POST">
        <label>Designation Title:</label><br>
        <input type="text" name="title" required><br><br>

        <label>Base Wage (Tsh):</label><br>
        <input type="number" step="0.01" name="base_wage" required><br><br>

        <button type="submit">Save</button>
    </form>
</div>

<?php include_once '../../includes/footer.php'; ?>
