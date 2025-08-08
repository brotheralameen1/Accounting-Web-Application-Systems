<?php
include_once '../../includes/db.php';
include_once '../../includes/header.php';
require_once '../../includes/auth_check.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM employees WHERE id = ?");
$stmt->execute([$id]);
$employee = $stmt->fetch();

if (!$employee) {
    echo "Employee not found!";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $phone = $_POST['phone'];

    $stmt = $pdo->prepare("UPDATE employees SET name = ?, phone = ? WHERE id = ?");
    $stmt->execute([$name, $phone, $id]);

    header("Location: index.php");
    exit;
}
?>

<div class="container">
    <h2>Edit Employee</h2>
    <form method="POST">
        <label>Name:</label><br>
        <input type="text" name="name" value="<?= htmlspecialchars($employee['name']) ?>" required><br><br>

        <label>Phone:</label><br>
        <input type="text" name="phone" value="<?= htmlspecialchars($employee['phone']) ?>"><br><br>

        <button type="submit">Update</button>
    </form>
</div>

<?php include_once '../../includes/footer.php'; ?>
