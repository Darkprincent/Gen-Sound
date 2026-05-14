<?php
session_start();
require_once "../models/model.php";
$imageName = 'default_album.png';
if ($_FILES['image']['error'] === 0) {
    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $imageName = time() . '_album_' . uniqid() . '.' . $ext;
    move_uploaded_file($_FILES['image']['tmp_name'], '../uploads/' . $imageName);
}
$data = [':name' => $_POST['name'], ':image' => $imageName, ':author_id' => $_SESSION['user']['id']];
insAlbum(addBD(), $data);
header("Location: ../index.php");
exit();