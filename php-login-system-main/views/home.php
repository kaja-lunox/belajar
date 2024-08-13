<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: ./login.php');
    exit();
}

require_once '../models/UserModel.php';

$userModel = new UserModel();
$user = $userModel->getUserById($_SESSION['id']);
if ($user !== null) {
    $name = $user['name'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
    <h2>Halo, <span><?php if (isset($name)) {
            echo $name;
        } 
        ?></span>
    </h2>

    <a href="../controllers/LogoutController.php">Logout</a>
    
</body>
</html>