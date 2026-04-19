<?php
session_start();
require_once "../models/model.php";

$id = $_GET['id'] ?? 0;
$pdo = addBD();

// (Опционально) Проверка прав: только автор или админ может удалить
// $track = selTrackFull($pdo, $id);
// if ($_SESSION['user']['role'] === 'admin' || $_SESSION['user']['id'] == $track['author_id']) { ... }

delTrack($pdo, $id);

header("Location: ../index.php");
exit();