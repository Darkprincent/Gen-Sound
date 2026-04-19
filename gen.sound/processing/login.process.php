<?php
session_start();
require_once "../models/model.php";

$user = selUser(addBD(), $_POST['name']);

// В твоем дампе пароли — числа, проверяем простое совпадение
if ($user && $user['password'] == $_POST['password']) {
    $_SESSION['user'] = [
        'id' => $user['id'],
        'name' => $user['name'],
        'role' => $user['role'] ?? 'user'
    ];
    header("Location: ../index.php");
} else {
    echo "Ошибка: Неверный логин или пароль. <a href='../views/login.view.php'>Назад</a>";
}
exit();