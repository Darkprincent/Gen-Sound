<?php
session_start();
require_once "../models/model.php";
$album = getAlbumById(addBD(), $_GET['id']);
$tracks = getAlbumTracks(addBD(), $_GET['id']);
include "../views/album.view.php";
?>