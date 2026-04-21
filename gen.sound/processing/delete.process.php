<?php
session_start();
require_once "../models/model.php";
delTrack(addBD(), $_GET['id']);
header("Location: ../index.php");
exit();