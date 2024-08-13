<?php
session_start();
require_once '../models/UserModel.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $userModel = new UserModel();
    $user = $userModel->login($email);

    if ($user) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['id'] = $user['id'];
            $_SESSION['password'] = $user['password'];
            header("Location: ../views/home.php");
            exit();
        } else {
            $_SESSION['password_error'] = "Password yang Anda masukkan salah";
            header("Location: ../views/login.php");
            exit();
        }
    } else {
        $_SESSION['email_error'] = "Email tidak terdaftar";

        $userModel->closeConnection();
        
        header("Location: ../views/login.php");
        exit();
    }
}

