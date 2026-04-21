<?php
session_start();
require_once "../models/model.php";

$coverName = 'default.jpg';
if (isset($_FILES['cover']) && $_FILES['cover']['error'] === 0) {
    $ext = pathinfo($_FILES['cover']['name'], PATHINFO_EXTENSION);
    $coverName = time() . '_' . uniqid() . '.' . $ext;
    move_uploaded_file($_FILES['cover']['tmp_name'], '../uploads/' . $coverName);
}

insTrack(addBD(), $_POST['title'], $_SESSION['user']['id'], $_POST['text'], $_POST['link'], $coverName);

header("Location: ../index.php");
exit();