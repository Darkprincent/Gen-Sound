<?php
session_start();
require_once "../models/model.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo = addBD();

    // 1. Логика загрузки файла
    $coverName = 'default.jpg'; // Название по умолчанию, если файл не выбрали
    if (isset($_FILES['cover']) && $_FILES['cover']['error'] === 0) {
        $extension = pathinfo($_FILES['cover']['name'], PATHINFO_EXTENSION);
        $coverName = time() . '_' . uniqid() . '.' . $extension; // Делаем имя уникальным
        $uploadPath = '../uploads/' . $coverName;

        move_uploaded_file($_FILES['cover']['tmp_name'], $uploadPath);
    }

    // 2. Подготовка данных для базы
    $data = [
        "title"     => $_POST['title'],
        "text"      => $_POST['text'],
        "link"      => $_POST['link'],
        "cover"     => $coverName,
        "author_id" => $_SESSION['user']['id']
    ];

    insTrack($pdo, $data);

    header("Location: ../index.php");
    exit();
}