<?php
// 1. ПОДКЛЮЧЕНИЕ К БД (Обязательно должно быть в начале)
$host = '127.0.0.1';
$db   = 'gen.sound';
$user = 'root';
$pass = ''; // В OpenServer по умолчанию пароль пустой или 'root'

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Ошибка подключения: " . $e->getMessage());
}

// 2. ЛОГИКА ДЛЯ РЕДАКТИРОВАНИЯ (Подгружаем данные, если есть edit_id)
$edit_data = null;
if (isset($_GET['edit_id'])) {
    $stmt = $pdo->prepare("SELECT t.id, t.title, t.author_id, l.text 
                           FROM tracks t 
                           LEFT JOIN lyrics l ON l.track_id = t.id 
                           WHERE t.id = ?");
    $stmt->execute([$_GET['edit_id']]);
    $edit_data = $stmt->fetch(PDO::FETCH_ASSOC);
}

// 3. ПОЛУЧЕНИЕ СПИСКА ПЕСЕН (Тот самый запрос на 10-й строчке)
// Теперь $pdo точно не null
$query = "SELECT t.id, t.title, a.name as author, a.id as author_id, l.text 
          FROM tracks t 
          JOIN authors a ON t.author_id = a.id 
          LEFT JOIN lyrics l ON l.track_id = t.id 
          ORDER BY t.id DESC";
$tracks = $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Gen Sound - Управление</title>
    <style>
        body { font-family: sans-serif; display: flex; gap: 40px; padding: 20px; background: #f9f9f9; }
        .form-container { width: 300px; background: white; padding: 20px; border: 1px solid #ccc; position: sticky; top: 20px; height: fit-content; }
        .list-container { flex-grow: 1; }
        .track-card { background: white; border: 1px solid #ddd; padding: 15px; margin-bottom: 10px; border-radius: 4px; }
        .track-header { border-bottom: 1px solid #eee; margin-bottom: 8px; padding-bottom: 4px; display: flex; justify-content: space-between; }
        .actions { margin-top: 10px; padding-top: 10px; border-top: 1px dashed #eee; }
        .btn-del { color: #d9534f; margin-left: 15px; text-decoration: none; }
        input, textarea, select { width: 100%; margin-bottom: 15px; padding: 8px; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background: #5cb85c; color: white; border: none; cursor: pointer; }
        button:hover { background: #4cae4c; }
    </style>
</head>
<body>

<div class="form-container">
    <h3><?= $edit_data ? "Изменить песню" : "Добавить новую" ?></h3>
    <form action="actions.php" method="POST">
        <input type="hidden" name="track_id" value="<?= $edit_data['id'] ?? '' ?>">

        <label>Автор:</label>
        <select name="author_id">
            <option value="1" <?= (isset($edit_data) && $edit_data['author_id'] == 1) ? 'selected' : '' ?>>Darprincent</option>
            <option value="2" <?= (isset($edit_data) && $edit_data['author_id'] == 2) ? 'selected' : '' ?>>WildOnMusic</option>
        </select>

        <label>Название трека:</label>
        <input type="text" name="title" value="<?= htmlspecialchars($edit_data['title'] ?? '') ?>" required>

        <label>Текст песни:</label>
        <textarea name="text" rows="8"><?= htmlspecialchars($edit_data['text'] ?? '') ?></textarea>

        <button type="submit"><?= $edit_data ? "Сохранить изменения" : "Опубликовать" ?></button>
        <?php if ($edit_data): ?>
            <a href="index.php" style="display:block; text-align:center; margin-top:10px; color: #666;">Отмена</a>
        <?php endif; ?>
    </form>
</div>

<div class="list-container">
    <h2>Список песен</h2>
    <?php if ($tracks): ?>
        <?php foreach ($tracks as $track): ?>
            <div class="track-card">
                <div class="track-header">
                    <strong><?= htmlspecialchars($track['title']) ?></strong>
                    <i style="color: #888;"><?= htmlspecialchars($track['author']) ?></i>
                </div>
                <div style="white-space: pre-line;"><?= nl2br(htmlspecialchars($track['text'] ?? 'Нет текста')) ?></div>

                <div class="actions">
                    <a href="?edit_id=<?= $track['id'] ?>">📝 Редактировать</a>
                    <a href="actions.php?delete_id=<?= $track['id'] ?>" class="btn-del" onclick="return confirm('Удалить эту песню?')">🗑 Удалить</a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Песен пока нет.</p>
    <?php endif; ?>
</div>

</body>
</html>