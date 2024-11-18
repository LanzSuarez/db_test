<?php
session_start();

// If the user is already logged in, redirect to the dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parking Website</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Welcome to the Parking Website</h1>
    </header>

    <main>
        <section class="intro">
            <h2>Get started by logging in or registering</h2>
        </section>

        <section class="auth-options">
            <div class="auth-option">
                <h3>Login</h3>
                <p>If you already have an account, please log in.</p>
                <a href="login.php">Login Here</a>
            </div>
            
            <div class="auth-option">
                <h3>Register</h3>
                <p>Don't have an account yet? Register now!</p>
                <a href="register.php">Register Here</a>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Parking Website. All rights reserved.</p>
    </footer>
</body>
</html>
