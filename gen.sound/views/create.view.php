<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Добавить трек</title>
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
    <h2 class="text-center mb-4" style="color: #d1b3ff;">НОВЫЙ ТРЕК</h2>
    <form action="../processing/store.process.php" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Название</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Обложка</label>
            <input type="file" name="image" class="form-control" accept="image/*">
        </div>
        <div class="mb-3">
            <label class="form-label">Ссылка на музыку</label>
            <input type="text" name="link" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Текст песни</label>
            <textarea name="lyric" class="form-control" rows="4"></textarea>
        </div>
        <button type="submit" class="btn btn-purple w-100">ОПУБЛИКОВАТЬ</button>
        <div class="mt-3 text-center"><a href="../index.php" class="text-white-50">← На главную</a></div>
    </form>
</div>
</body>
</html>