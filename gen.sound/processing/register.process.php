<?php
session_start();
require_once "../models/model.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo = addBD();
    $name = trim($_POST['name']);
    $pass = $_POST['password'];

    // Создаем пользователя
    $userId = regUser($pdo, $name, $pass);

    // Сразу авторизуем
    $_SESSION['user'] = [
        'id' => $userId,
        'name' => $name,
        'role' => 'user'
    ];

    header("Location: ../index.php");
    exit();
}