<?php
include_once '../../includes/db.php';
include_once '../../includes/header.php';
require_once '../../includes/auth_check.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $phone = $_POST['phone'];

    $stmt = $pdo->prepare("INSERT INTO employees (name, phone) VALUES (?, ?)");
    $stmt->execute([$name, $phone]);

    header("Location: index.php");
    exit;
}
?>

<div class="container">
    <h2>Add Employee</h2>
    <form method="POST">
        <label>Name:</label><br>
        <input type="text" name="name" required><br><br>

        <label>Phone:</label><br>
        <input type="text" name="phone"><br><br>

        <button type="submit">Save</button>
    </form>
</div>

<?php include_once '../../includes/footer.php'; ?>
