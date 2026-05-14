<?php
session_start();
require_once "models/model.php";
$tracks = selAllTracks(addBD());
include "views/index.view.php";
?>