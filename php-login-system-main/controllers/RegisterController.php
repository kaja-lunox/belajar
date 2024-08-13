<?php

session_start();

require_once '../models/UserModel.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $date_of_birth = $_POST['date_of_birth'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password != $confirm_password) {
        echo "Konfirmasi password tidak sesuai";
        exit;
    }

    $userModel = new UserModel();

    $userModel->register($name, $gender, $date_of_birth, $email, $phone_number, $password);

    $_SESSION['id'] = $userModel->login($email)['id'];

    $userModel->closeConnection();
    
    header("Location: ../views/home.php");
    exit();
}

