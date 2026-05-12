<?php
session_start();
require_once "../models/model.php";

if (isset($_SESSION['user']) && isset($_POST['rate'])) {
    $data = [
        ':rate'     => $_POST['rate'],
        ':user_id'  => $_SESSION['user']['id'],
        ':track_id' => $_POST['track_id']
    ];
    setRating(addBD(), $data);
}

header("Location: ../processing/show.process.php?id=" . $_POST['track_id']);
exit();