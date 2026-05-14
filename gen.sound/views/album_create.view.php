<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Создать альбом</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>body{background:#1a0a2e;color:white;padding:50px}.form-card{background:rgba(20,10,40,0.8);border-radius:20px;padding:40px;max-width:500px;margin:auto}</style>
</head>
<body>
<div class="form-card">
    <h2>Новый альбом</h2>
    <form action="../processing/album.store.process.php" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Название</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Обложка</label>
            <input type="file" name="image" class="form-control" accept="image/*">
        </div>
        <button type="submit" class="btn btn-success">Создать</button>
        <a href="../index.php" class="btn btn-secondary">Назад</a>
    </form>
</div>
</body>
</html>