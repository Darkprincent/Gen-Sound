<?php
require_once "../models/model.php";

$pdo = addBD();
$id = $_GET['id'] ?? 0;

// Используем уже готовую функцию selTrackFull, чтобы получить название и текст
$track = selTrackFull($pdo, $id);

if (!$track) {
    die("Трек для редактирования не найден");
}

include "../views/select.view.php";