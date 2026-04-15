<?php
// Настройки подключения (согласно дампу БД)
$db   = 'gen.sound'; // Имя базы из вашего SQL
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=localhost;dbname=$db;charset=$charset";
$pdo = new PDO($dsn, $user, $pass);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $text = $_POST['text'];
    $author_id = $_POST['author_id']; // В реальности здесь должен быть ID авторизованного автора

    try {
        $pdo->beginTransaction();

        // 1. Создаем трек
        $stmt = $pdo->prepare("INSERT INTO tracks (title, author_id) VALUES (?, ?)");
        $stmt->execute([$title, $author_id]);
        $track_id = $pdo->lastInsertId();

        // 2. Добавляем текст песни, привязывая его к ID трека
        $stmt = $pdo->prepare("INSERT INTO lyrics (text, track_id) VALUES (?, ?)");
        $stmt->execute([$text, $track_id]);

        $pdo->commit();
        echo "Песня успешно добавлена!";
    } catch (Exception $e) {
        $pdo->rollBack();
        echo "Ошибка: " . $e->getMessage();
    }
}
?>