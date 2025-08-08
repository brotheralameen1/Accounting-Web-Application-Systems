<?php
session_start();
require_once "includes/db.php";

if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

$loginError = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if ($username && $password) {
        // Prepare and execute PDO statement
        $stmt = $pdo->prepare("SELECT id, username, password FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                header("Location: dashboard.php");
                exit();
            } else {
                $loginError = "Incorrect password.";
            }
        } else {
            $loginError = "User not found.";
        }
    } else {
        $loginError = "All fields are required.";
    }
}
?>

<?php include "includes/header.php"; ?>

<div class="form-container">
    <h2>Login</h2>
    <?php if ($loginError): ?>
        <p class="error"><?= htmlspecialchars($loginError) ?></p>
    <?php endif; ?>
    <form method="POST" action="">
        <label for="username">Username:</label>
        <input type="text" name="username" required>
        
        <label for="password">Password:</label>
        <input type="password" name="password" required>
        
        <button type="submit">Login</button>
    </form>
    <p><a href="modules/auth/reset_password.php">Forgot Password?</a></p>
</div>

<?php include "includes/footer.php"; ?>
