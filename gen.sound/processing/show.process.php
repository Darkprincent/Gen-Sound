<?php
require_once "../models/model.php";

$pdo = addBD();
$id = $_GET['id'] ?? 0;

// Получаем полные данные трека через функцию из модели
$track = selTrackFull($pdo, $id);

$link = getTrackLink($pdo, $id);

if (!$track) {
    die("Трек не найден");
}

// Подключаем визуальную часть
include "../views/show.view.php";
?>