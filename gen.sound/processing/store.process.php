<?php
session_start();
require_once "../models/model.php";

$imageName = 'default.jpg';
if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $imageName = time() . '_' . uniqid() . '.' . $ext;
    move_uploaded_file($_FILES['image']['tmp_name'], '../uploads/' . $imageName);
}

// Формируем массив данных
$data = [
    ':title'     => $_POST['title'],
    ':author_id' => $_SESSION['user']['id'],
    ':image'     => $imageName,
    ':lyric'     => $_POST['lyric'],
    ':link'      => $_POST['link']
];


insTrack(addBD(), $data);

header("Location: ../index.php");
exit();