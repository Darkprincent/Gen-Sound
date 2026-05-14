<?php
session_start();
require_once "../models/model.php";

$album_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($album_id <= 0) {
    echo "Неверный ID альбома";
    exit();
}

$album = getAlbumById(addBD(), $album_id);

if (!$album) {
    echo "Альбом не найден";
    exit();
}

if (!isset($_SESSION['user']) || ($_SESSION['user']['id'] != $album['author_id'] && $_SESSION['user']['role'] != 'admin')) {
    echo "У вас нет прав для редактирования этого альбома";
    exit();
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Редактировать альбом</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #1a0a2e; color: white; padding: 50px; }
        .form-card { background: rgba(20,10,40,0.8); border-radius: 20px; padding: 40px; max-width: 500px; margin: auto; }
        .form-control { background: rgba(255,255,255,0.05); border: 1px solid #4a308d; color: white; }
        .current-cover { max-width: 200px; border-radius: 10px; margin-top: 10px; border: 2px solid #6a4bc2; }
    </style>
</head>
<body>
<div class="form-card">
    <h2 class="text-center mb-4">Редактировать альбом</h2>
    <form action="../processing/album.update.process.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $album['id'] ?>">
        <input type="hidden" name="old_image" value="<?= htmlspecialchars($album['image']) ?>">

        <div class="mb-3">
            <label class="form-label">Название</label>
            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($album['name']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Текущая обложка</label><br>
            <?php
            $coverPath = '../uploads/' . $album['image'];
            if (!empty($album['image']) && file_exists($coverPath)):
                ?>
                <img src="<?= $coverPath ?>" class="current-cover" alt="Обложка альбома">
            <?php else: ?>
                <p class="text-muted">Нет обложки</p>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label class="form-label">Новая обложка</label>
            <input type="file" name="image" class="form-control" accept="image/*">
            <small class="text-white-50">Оставьте пустым, чтобы не менять</small>
        </div>

        <button type="submit" class="btn btn-warning w-100">Сохранить</button>
        <a href="../processing/author.process.php?id=<?= $album['author_id'] ?>" class="btn btn-secondary w-100 mt-2">Назад</a>
    </form>
</div>
</body>
</html>