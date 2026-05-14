<?php
session_start();
require_once "../models/model.php";
if (isset($_SESSION['user'], $_POST['rate'], $_POST['track_id'])) {
    $data = [
        ':rate' => $_POST['rate'],
        ':user_id' => $_SESSION['user']['id'],
        ':track_id' => $_POST['track_id']
    ];
    setRating(addBD(), $data);
}
header("Location: ../index.php");
exit();