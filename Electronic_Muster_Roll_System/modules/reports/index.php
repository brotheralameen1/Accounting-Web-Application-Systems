<?php
include_once '../../includes/db.php';
include_once '../../includes/header.php';
require_once '../../includes/auth_check.php';
?>

<div class="container">
    <h2>Reports</h2>
    <ul>
        <li><a href="daily.php">Daily Activity Report</a></li>
        <li><a href="monthly.php">Monthly Payroll Report</a></li>
    </ul>
</div>

<?php include_once '../../includes/footer.php'; ?>
