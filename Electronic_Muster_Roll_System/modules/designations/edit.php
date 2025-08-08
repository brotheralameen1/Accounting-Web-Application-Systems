<?php
include_once '../../includes/db.php';
include_once '../../includes/header.php';
require_once '../../includes/auth_check.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM designations WHERE id = ?");
$stmt->execute([$id]);
$designation = $stmt->fetch();

if (!$designation) {
    echo "Designation not found!";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $base_wage = $_POST['base_wage'];

    $stmt = $pdo->prepare("UPDATE designations SET title = ?, base_wage = ? WHERE id = ?");
    $stmt->execute([$title, $base_wage, $id]);

    header("Location: index.php");
    exit;
}
?>

<div class="container">
    <h2>Edit Designation</h2>
    <form method="POST">
        <label>Designation Title:</label><br>
        <input type="text" name="title" value="<?= htmlspecialchars($designation['title']) ?>" required><br><br>

        <label>Base Wage (Tsh):</label><br>
        <input type="number" step="0.01" name="base_wage" value="<?= $designation['base_wage'] ?>" required><br><br>

        <button type="submit">Update</button>
    </form>
</div>

<?php include_once '../../includes/footer.php'; ?>
