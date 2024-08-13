<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form action="../controllers/LoginController.php" method="POST">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <?php
        if (isset($_SESSION['email_error'])) {
            echo "<p>{$_SESSION['email_error']}</p>";
            unset($_SESSION['email_error']);
        }
        ?>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <?php
        if (isset($_SESSION['password_error'])) {
            echo "<p>{$_SESSION['password_error']}</p>";
            unset($_SESSION['password_error']);
        }
        ?>

        <input type="submit" value="Login"><br>
        <span>Belum punya akun? <a href="./register.php">Daftar</a></span>
    </form>
</body>
</html>