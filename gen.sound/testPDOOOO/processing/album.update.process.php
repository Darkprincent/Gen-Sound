<?php
session_start();
require_once "../models/model.php";
$imageName = $_POST['old_image'];
if ($_FILES['image']['error'] === 0) {
    if ($imageName != 'default_album.png') unlink('../uploads/' . $imageName);
    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $imageName = time() . '_album_' . uniqid() . '.' . $ext;
    move_uploaded_file($_FILES['image']['tmp_name'], '../uploads/' . $imageName);
}
$data = [':id' => $_POST['id'], ':name' => $_POST['name'], ':image' => $imageName];
updAlbum(addBD(), $data);
header("Location: ../index.php");
exit();