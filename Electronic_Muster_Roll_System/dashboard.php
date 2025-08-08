<?php
session_start();
require_once "includes/db.php";

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include "includes/header.php";
?>

<div class="container">
    <h2>Welcome, <?= htmlspecialchars($_SESSION['username']) ?>!</h2>
    <p>This is the dashboard of Muster Roll System by Alameen Karim Merali.</p>

    <div class="dashboard-links" style="display:flex; gap:20px; flex-wrap: wrap;">
        <a href="modules/employees/" class="btn">Employees</a>
        <a href="modules/designations/" class="btn">Designations</a>
        <a href="modules/shifts/" class="btn">Shifts</a>
        <a href="modules/attendance/" class="btn">Attendance</a>
        <a href="modules/loans/" class="btn">Loans</a>
        <a href="modules/reports/" class="btn">Reports</a>
		<a href="modules/reports/daily_salary_report.php" class="btn btn-info">Daily Salary Report</a>
        <a href="modules/auth/logout.php" class="btn btn-logout">Logout</a>
    </div>
</div>

<style>
.container {
    max-width: 900px;
    margin: 2rem auto;
    padding: 1rem;
}
.dashboard-links a.btn {
    padding: 1rem 1.5rem;
    background-color: #007BFF;
    color: white;
    text-decoration: none;
    border-radius: 6px;
    font-weight: 600;
    box-shadow: 0 2px 5px rgb(0 0 0 / 0.15);
    transition: background-color 0.3s ease;
}
.dashboard-links a.btn:hover {
    background-color: #0056b3;
}
.dashboard-links a.btn-logout {
    background-color: #dc3545;
}
.dashboard-links a.btn-logout:hover {
    background-color: #a71d2a;
}
</style>

<?php include "includes/footer.php"; ?>
