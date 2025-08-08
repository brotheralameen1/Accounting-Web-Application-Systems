<?php
// Start session for access control
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Alameen Karim Merali - Muster Roll System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- CSS -->
    <link rel="stylesheet" href="/includes/style.css">

    <!-- JS -->
    <script src="/assets/js/script.js" defer></script>

    <!-- Optional: Font and Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <header>
        <h1>Electronic Muster Roll System created by Alameen Karim Merali</h1>
        <h2>Muster Roll System</h2>
        <nav>
            <a href="/dashboard.php">Dashboard</a>
            <a href="/modules/employees/">Employees</a>
            <a href="/modules/designations/">Designations</a>
            <a href="/modules/shifts/">Shifts</a>
            <a href="/modules/attendance/">Attendance</a>
            <a href="/modules/loans/">Loans</a>
            <a href="/modules/reports/">Reports</a>
			<a href="/modules/reports/daily_salary_report.php">Daily Salary Report</a>
			<a href="/modules/auth/logout.php">Logout</a>
        </nav>
        <hr>
    </header>
    <main>
