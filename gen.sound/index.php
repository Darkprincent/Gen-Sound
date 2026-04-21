<?php
session_start();
require_once "models/model.php";
$pdo = addBD();
$tracks = getAllTracks($pdo);
include "views/index.view.php";