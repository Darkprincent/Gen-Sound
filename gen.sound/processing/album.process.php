<?php
require_once "../models/model.php";

$pdo = addBD();
$id = $_GET['id'];

// Используем функции из модели
$album = getAlbumId($pdo, $id);
$tracks = getAlbumTracks($pdo, $id);

include "../views/album.view.php";