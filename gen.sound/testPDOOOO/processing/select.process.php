<?php
session_start();
require_once "../models/model.php";
$track = selTrackId(addBD(), $_GET['id']);
include "../views/select.view.php";
?>