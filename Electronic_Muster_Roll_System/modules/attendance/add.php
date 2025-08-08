<?php
include_once '../../includes/db.php';
include_once '../../includes/header.php';
require_once '../../includes/auth_check.php';

$employees = $pdo->query("SELECT * FROM employees")->fetchAll();
$designations = $pdo->query("SELECT * FROM designations")->fetchAll();
$shifts = $pdo->query("SELECT * FROM shifts")->fetchAll();

$date = $_GET['date'] ?? date('Y-m-d');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employee_id = $_POST['employee_id'];
    $designation_id = $_POST['designation_id'];
    $shift_id = $_POST['shift_id'];
    $task_note = $_POST['task_note'];
    $attendance_date = $_POST['attendance_date'];

    // Determine wage (priority: shift wage > designation wage)
    $stmt = $pdo->prepare("SELECT wage_per_day FROM shifts WHERE id = ?");
    $stmt->execute([$shift_id]);
    $shift_wage = $stmt->fetchColumn();

    if (!$shift_wage) {
        $stmt = $pdo->prepare("SELECT base_wage FROM designations WHERE id = ?");
        $stmt->execute([$designation_id]);
        $shift_wage = $stmt->fetchColumn();
    }

    $stmt = $pdo->prepare("
        INSERT INTO attendance (employee_id, designation_id, shift_id, task_note, attendance_date, wage)
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    $stmt->execute([$employee_id, $designation_id, $shift_id, $task_note, $attendance_date, $shift_wage]);

    header("Location: index.php?date=$attendance_date");
    exit;
}
?>

<div class="container">
    <h2>Add Attendance Entry</h2>
    <form method="POST">
        <label>Date:</label><br>
        <input type="date" name="attendance_date" value="<?= $date ?>" required><br><br>

        <label>Employee:</label><br>
        <select name="employee_id" required>
            <option value="">-- Select --</option>
            <?php foreach ($employees as $emp): ?>
                <option value="<?= $emp['id'] ?>"><?= htmlspecialchars($emp['name']) ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label>Designation:</label><br>
        <select name="designation_id" required>
            <option value="">-- Select --</option>
            <?php foreach ($designations as $des): ?>
                <option value="<?= $des['id'] ?>"><?= htmlspecialchars($des['title']) ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label>Shift:</label><br>
        <select name="shift_id" required>
            <option value="">-- Select --</option>
            <?php foreach ($shifts as $shift): ?>
                <option value="<?= $shift['id'] ?>"><?= htmlspecialchars($shift['name']) ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label>Task Note (optional):</label><br>
        <textarea name="task_note" rows="3"></textarea><br><br>

        <button type="submit">Save</button>
    </form>
</div>

<?php include_once '../../includes/footer.php'; ?>
