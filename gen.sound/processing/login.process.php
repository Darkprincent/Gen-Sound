<?php
session_start();
require_once "../models/model.php";

$pdo = addBD();
// Исправлено: передаем просто строку, а не массив
$user = selUserName($pdo, $_POST['name']);

// ВАЖНО: Сейчас у тебя пароли в БД открытые.
// Если начнешь использовать password_hash, тут нужно будет password_verify
if ($user && $user['password'] == $_POST['password']) {
    $_SESSION['user'] = [
        'id' => $user['id'],
        'name' => $user['name'],
        'role' => $user['role']
    ];
    header("Location: ../index.php");
} else {
    echo "Ошибка! Неверное имя или пароль. <a href='../views/login.view.php'>Назад</a>";
}
exit();