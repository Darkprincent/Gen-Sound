<?php
session_start();
require_once "../models/model.php";

$data = [
    ':name'     => $_POST['name'],
    ':password' => $_POST['password']
];


$userId = insUser(addBD(), $data);

$_SESSION['user'] = ['id' => $userId, 'name' => $_POST['name'], 'role' => 'user'];

header("Location: ../index.php");
exit();