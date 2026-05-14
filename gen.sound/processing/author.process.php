<?php
session_start();
require_once "../models/model.php";
$author = selUserId(addBD(), $_GET['id']);
$albums = getAuthorAlbums(addBD(), $_GET['id']);
$tracks = getAuthorTracks(addBD(), $_GET['id']);
include "../views/author.view.php";
?>