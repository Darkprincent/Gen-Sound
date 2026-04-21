<?php
session_start();
require_once "../models/model.php";

$coverName = $_POST['old_cover'];
if (isset($_FILES['cover']) && $_FILES['cover']['error'] === 0) {
    $ext = pathinfo($_FILES['cover']['name'], PATHINFO_EXTENSION);
    $coverName = time() . '_' . uniqid() . '.' . $ext;
    move_uploaded_file($_FILES['cover']['tmp_name'], '../uploads/' . $coverName);
}

updTrack(addBD(), $_POST['id'], $_POST['title'], $_POST['text'], $_POST['link'], $coverName);

header("Location: ../index.php");
exit();