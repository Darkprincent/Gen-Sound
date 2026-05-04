<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Редактирование трека - Gen Sound</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #2e1065; color: white; display: flex; align-items: center; justify-content: center; min-height: 100vh; }
        .form-card { background: rgba(20,10,40,0.8); border: 1px solid #6a4bc2; border-radius: 20px; padding: 40px; max-width: 500px; }
        .form-control { background: rgba(255,255,255,0.05); border: 1px solid #4a308d; color: white; }
        .label-purple { color: #d1b3ff; font-weight: bold; }
        .btn-purple { background: #6a4bc2; color: white; border: none; }
    </style>
</head>
<body>
<div class="form-card">
    <h2 class="text-center mb-4" style="color: #d1b3ff;">РЕДАКТИРОВАНИЕ</h2>

    <form action="../processing/update.process.php" method="post" enctype="multipart/form-data">

        <!-- Скрытое поле с ID трека (нужно для обновления в БД) -->
        <input type="hidden" name="id" value="<?php echo $track['id']; ?>">

        <!-- Скрытое поле со старым именем фото (если новое не загрузят - останется старое) -->
        <input type="hidden" name="old_cover" value="<?php echo $track['image']; ?>">

        <!-- Поле НАЗВАНИЕ -->
        <div class="mb-3">
            <label class="label-purple">Название трека</label>
            <input type="text" name="title" class="form-control" value="<?php echo $track['title']; ?>" required>
        </div>

        <!-- Поле ФОТО -->
        <div class="mb-3">
            <label class="label-purple">Обновить обложку (фотографию)</label>
            <input type="file" name="cover" class="form-control" accept="image/*">
            <?php if (!empty($track['image'])): ?>
                <div style="color: #a582ff; font-size: 14px; margin-top: 5px;">
                    Текущая обложка: <?php echo $track['image']; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Поле ССЫЛКА -->
        <div class="mb-3">
            <label class="label-purple">Ссылка на музыку</label>
            <input type="text" name="link" class="form-control" value="<?php echo $link; ?>" placeholder="https://...">
        </div>

        <!-- Поле ТЕКСТ -->
        <div class="mb-3">
            <label class="label-purple">Текст песни</label>
            <textarea name="text" class="form-control" rows="5"><?php echo $track['lyric']; ?></textarea>
        </div>

        <button type="submit" class="btn-purple w-100 py-2 fw-bold">СОХРАНИТЬ ИЗМЕНЕНИЯ</button>

        <div class="mt-4 text-center">
            <a href="../index.php" style="color: #aaa; font-size: 14px;">← Назад в меню</a>
        </div>
    </form>
</div>
</body>
</html>