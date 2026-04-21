<?php
session_start();
require_once "../models/model.php";

$user = selUser(addBD(), $_POST['name']);

if ($user && $user['password'] == $_POST['password']) {
    $_SESSION['user'] = ['id' => $user['id'], 'name' => $user['name'], 'role' => $user['role']];
    header("Location: ../index.php");
} else {
    echo "Ошибка! <a href='../views/login.view.php'>Назад</a>";
}
exit();