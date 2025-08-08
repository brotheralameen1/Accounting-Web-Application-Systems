<?php
include_once '../../includes/db.php';
include_once '../../includes/header.php';
require_once '../../includes/auth_check.php';

$designations = $pdo->query("SELECT * FROM designations")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $designation_id = $_POST['designation_id'];
    $has_time = isset($_POST['has_time']) ? 1 : 0;
    $start_time = $has_time ? $_POST['start_time'] : null;
    $end_time = $has_time ? $_POST['end_time'] : null;
    $wage_per_day = $_POST['wage_per_day'];

    $stmt = $pdo->prepare("INSERT INTO shifts (name, designation_id, has_time, start_time, end_time, wage_per_day)
                           VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$name, $designation_id, $has_time, $start_time, $end_time, $wage_per_day]);

    header("Location: index.php");
    exit;
}
?>

<div class="container">
    <h2>Add Shift</h2>
    <form method="POST">
        <label>Shift Name:</label><br>
        <input type="text" name="name" required><br><br>

        <label>Designation:</label><br>
        <select name="designation_id" required>
            <option value="">-- Select Designation --</option>
            <?php foreach ($designations as $des) : ?>
                <option value="<?= $des['id'] ?>"><?= htmlspecialchars($des['title']) ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <input type="checkbox" name="has_time" id="has_time" checked onchange="toggleTimeFields()">
        <label for="has_time">This shift has a time range</label><br><br>

        <div id="time_fields">
            <label>Start Time:</label><br>
            <input type="time" name="start_time"><br><br>

            <label>End Time:</label><br>
            <input type="time" name="end_time"><br><br>
        </div>

        <label>Wage Per Day (Tsh):</label><br>
        <input type="number" step="0.01" name="wage_per_day" required><br><br>

        <button type="submit">Save</button>
    </form>
</div>

<script>
function toggleTimeFields() {
    const timeFields = document.getElementById('time_fields');
    const hasTimeCheckbox = document.getElementById('has_time');
    timeFields.style.display = hasTimeCheckbox.checked ? 'block' : 'none';
}
toggleTimeFields();
</script>

<?php include_once '../../includes/footer.php'; ?>
