<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Редактирование</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #1a0a2e; color: white; display: flex; justify-content: center; align-items: center; min-height: 100vh; }
        .form-card { background: rgba(20,10,40,0.8); border: 1px solid #6a4bc2; border-radius: 20px; padding: 40px; max-width: 500px; }
        .form-control { background: rgba(255,255,255,0.05); border: 1px solid #4a308d; color: white; }
        .btn-purple { background: #6a4bc2; color: white; }
    </style>
</head>
<body>
<div class="form-card">
    <h2 class="text-center mb-4" style="color: #d1b3ff;">РЕДАКТИРОВАНИЕ</h2>
    <form action="../processing/update.process.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $track['id'] ?>">
        <input type="hidden" name="old_image" value="<?= $track['image'] ?>">

        <div class="mb-3">
            <label class="form-label">Название</label>
            <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($track['title']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Альбом</label>
            <select name="album_id" class="form-control">
                <option value="">Без альбома</option>
                <?php

                $all_albums = getAuthorAlbums(addBD(), $_SESSION['user']['id']);
                foreach ($all_albums as $album):
                    ?>
                    <option value="<?= $album['id'] ?>" <?= ($album['id'] == $track['album_id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($album['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Новая обложка</label>
            <input type="file" name="image" class="form-control" accept="image/*">
            <small class="text-white-50">Текущая: <?= $track['image'] ?></small>
        </div>

        <div class="mb-3">
            <label class="form-label">Ссылка (аудио)</label>
            <input type="text" name="link" class="form-control" value="<?= htmlspecialchars($track['link']) ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Текст песни</label>
            <textarea name="lyric" class="form-control" rows="4"><?= htmlspecialchars($track['lyric']) ?></textarea>
        </div>

        <button type="submit" class="btn btn-purple w-100">СОХРАНИТЬ ИЗМЕНЕНИЯ</button>
        <div class="mt-3 text-center"><a href="../index.php" class="text-white-50">← На главную</a></div>
    </form>
</div>
</body>
</html>