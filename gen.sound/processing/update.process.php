<?php
session_start();
require_once "../models/model.php";

$imageName = $_POST['old_image'];
if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
    // Удаляем старую обложку
    if ($imageName != 'default.jpg' && file_exists('../uploads/' . $imageName)) {
        unlink('../uploads/' . $imageName);
    }
    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $imageName = time() . '_' . uniqid() . '.' . $ext;
    move_uploaded_file($_FILES['image']['tmp_name'], '../uploads/' . $imageName);
}

$data = [
    ':id' => $_POST['id'],
    ':title' => $_POST['title'],
    ':lyric' => $_POST['lyric'],
    ':link' => $_POST['link'],
    ':image' => $imageName
];

updTrack(addBD(), $data);

header("Location: ../index.php");
exit();