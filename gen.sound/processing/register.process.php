<?php
session_start();
require_once "../models/model.php";

$userId = regUser(addBD(), trim($_POST['name']), $_POST['password']);

$_SESSION['user'] = ['id' => $userId, 'name' => $_POST['name'], 'role' => 'user'];

header("Location: ../index.php");
exit();