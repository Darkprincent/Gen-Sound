<?php
session_start();
require_once "../models/model.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo = addBD();
    $id = $_POST['id'];

    // Получаем имя старой обложки из скрытого поля (которое мы добавили в форму)
    $coverName = $_POST['old_cover'];

    // Проверяем, загрузил ли пользователь новый файл
    if (isset($_FILES['cover']) && $_FILES['cover']['error'] === 0) {
        $extension = pathinfo($_FILES['cover']['name'], PATHINFO_EXTENSION);
        $newFileName = time() . '_' . uniqid() . '.' . $extension;

        if (move_uploaded_file($_FILES['cover']['tmp_name'], '../uploads/' . $newFileName)) {
            $coverName = $newFileName; // Если загрузка успешна, используем новое имя
        }
    }

    $data = [
        "id"    => $id,
        "title" => $_POST['title'],
        "text"  => $_POST['text'],
        "link"  => $_POST['link'],
        "cover" => $coverName
    ];

    // Вызываем ту самую функцию, которая выдавала ошибку
    upd($pdo, $data);

    header("Location: ../index.php");
    exit();
}