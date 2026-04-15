<?php
$host = '127.0.0.1';
$db   = 'gen.sound';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Ошибка подключения: " . $e->getMessage());
}

// УДАЛЕНИЕ
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $pdo->prepare("DELETE FROM lyrics WHERE track_id = ?")->execute([$id]);
    $pdo->prepare("DELETE FROM tracks WHERE id = ?")->execute([$id]);
    header("Location: index.php");
    exit;
}

// ДОБАВЛЕНИЕ ИЛИ ИЗМЕНЕНИЕ
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $text = trim($_POST['text']);
    $author_id = $_POST['author_id'];
    $track_id = $_POST['track_id'] ?? null;

    if ($track_id) {
        // --- ОБНОВЛЕНИЕ ---

        // 1. Обновляем название и автора
        $pdo->prepare("UPDATE tracks SET title = ?, author_id = ? WHERE id = ?")
            ->execute([$title, $author_id, $track_id]);

        // 2. Проверяем, существует ли уже текст для этого трека
        $check_lyric = $pdo->prepare("SELECT id FROM lyrics WHERE track_id = ?");
        $check_lyric->execute([$track_id]);

        if ($check_lyric->fetch()) {
            // Если текст есть — обновляем
            $pdo->prepare("UPDATE lyrics SET text = ? WHERE track_id = ?")->execute([$text, $track_id]);
        } else {
            // Если текста не было (как у старых треков из дампа) — вставляем новый
            $pdo->prepare("INSERT INTO lyrics (text, track_id) VALUES (?, ?)")->execute([$text, $track_id]);
        }

    } else {
        // --- НОВОЕ ДОБАВЛЕНИЕ ---
        $pdo->prepare("INSERT INTO tracks (title, author_id) VALUES (?, ?)")->execute([$title, $author_id]);
        $new_id = $pdo->lastInsertId();

        $pdo->prepare("INSERT INTO lyrics (text, track_id) VALUES (?, ?)")->execute([$text, $new_id]);
    }

    // Возвращаемся на главную страницу
    header("Location: index.php");
    exit;
}