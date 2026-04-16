<?php
session_start(); // Запускаем сессию для работы с профилями

// 1. Подключение к БД
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

// 2. Получаем текущего пользователя из сессии (если он вошел)
$currentUser = $_SESSION['user'] ?? null; // Содержит id, name, role

// 3. Запрос данных: трек + автор + текст + обложка
$query = "SELECT 
            t.id, t.title, t.author_id,
            a.name as author_name, 
            l.text as lyric_text,
            img.image as cover_blob
          FROM tracks t
          JOIN authors a ON t.author_id = a.id
          LEFT JOIN lyrics l ON l.track_id = t.id
          LEFT JOIN images img ON img.track_id = t.id
          ORDER BY t.id DESC";

$tracks = $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Gen Sound - Главная</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f0f2f5; margin: 0; padding: 20px; }
        .header { display: flex; justify-content: space-between; align-items: center; background: #fff; padding: 10px 20px; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .container { max-width: 900px; margin: auto; }

        /* Стили карточек песен по вашему наброску */
        .track-card { background: #fff; border-radius: 8px; padding: 15px; margin-bottom: 15px; display: flex; gap: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        .cover-art { width: 120px; height: 120px; background: #ddd; border-radius: 4px; overflow: hidden; flex-shrink: 0; }
        .cover-art img { width: 100%; height: 100%; object-fit: cover; }

        .track-info { flex-grow: 1; }
        .track-title { font-size: 1.4em; margin: 0 0 5px 0; color: #1c1e21; }
        .track-author { color: #65676b; font-size: 0.9em; margin-bottom: 10px; }
        .track-preview { color: #4b4f56; line-height: 1.4; margin-bottom: 10px; }

        .actions { display: flex; gap: 15px; font-size: 0.85em; margin-top: 10px; }
        .btn-more { color: #007bff; text-decoration: none; font-weight: bold; }
        .btn-edit { color: #28a745; text-decoration: none; }
        .btn-del { color: #dc3545; text-decoration: none; }
        .btn-add { background: #007bff; color: white; padding: 8px 16px; border-radius: 5px; text-decoration: none; }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1>Gen Sound</h1>
        <div class="user-box">
            <?php if ($currentUser): ?>
                <span>Привет, <b><?= htmlspecialchars($currentUser['name']) ?></b> (<?= $currentUser['role'] ?>)</span> |
                <a href="logout.php">Выйти</a>
                <?php if ($currentUser['role'] !== 'guest'): ?>
                    <br><br><a href="add_track.php" class="btn-add">+ Добавить трек</a>
                <?php endif; ?>
            <?php else: ?>
                <a href="login.php">Войти</a> | <a href="register.php">Регистрация</a>
            <?php endif; ?>
        </div>
    </div>

    <div class="list">
        <?php foreach ($tracks as $track): ?>
            <div class="track-card">
                <div class="cover-art">
                    <?php if ($track['cover_blob']): ?>
                        <img src="data:image/jpeg;base64,<?= base64_encode($track['cover_blob']) ?>" alt="Cover">
                    <?php else: ?>
                        <div style="padding:40px 10px; text-align:center; color:#999;">No Image</div>
                    <?php endif; ?>
                </div>

                <div class="track-info">
                    <h2 class="track-title"><?= htmlspecialchars($track['title']) ?></h2>
                    <div class="track-author">Исполнитель: <?= htmlspecialchars($track['author_name']) ?></div>

                    <div class="track-preview">
                        <?= mb_strimwidth(htmlspecialchars($track['lyric_text'] ?? ''), 0, 150, "...") ?>
                    </div>

                    <div class="actions">
                        <a href="view_track.php?id=<?= $track['id'] ?>" class="btn-more">Просмотреть всё</a>

                        <?php
                        // Логика прав доступа по бизнес-плану:
                        $isOwner = ($currentUser && $currentUser['id'] == $track['author_id']);
                        $isAdmin = ($currentUser && $currentUser['role'] === 'admin');

                        if ($isOwner || $isAdmin): ?>
                            <a href="edit_track.php?id=<?= $track['id'] ?>" class="btn-edit">📝 Редактировать</a>
                            <a href="actions.php?delete_id=<?= $track['id'] ?>" class="btn-del" onclick="return confirm('Удалить?')">🗑 Удалить</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

</body>
</html>