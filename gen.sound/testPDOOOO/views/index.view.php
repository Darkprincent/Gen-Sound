<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Gen Sound - Главная</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #1a0a2e; color: white; min-height: 100vh; padding: 30px; }
        .btn-purple { background: #6a4bc2; color: white; border: none; }
        .btn-purple:hover { background: #8261e1; color: white; }
        .table-glass { background: rgba(255,255,255,0.05); border-radius: 15px; }
        .track-img { width: 50px; height: 50px; object-fit: cover; border-radius: 8px; }
    </style>
</head>
<body>
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 style="color: #d1b3ff;">GEN SOUND</h1>
        <?php if (isset($_SESSION['user'])): ?>
            <div>
                <span>Привет, <b><?= $_SESSION['user']['name'] ?></b></span>
                <a href="views/create.view.php" class="btn btn-purple ms-3">+ Добавить трек</a>
                <a href="processing/logout.process.php" class="btn btn-outline-danger ms-2">Выход</a>
            </div>
        <?php else: ?>
            <a href="views/login.view.php" class="btn btn-purple">Войти</a>
        <?php endif; ?>
    </div>

    <div class="table-responsive table-glass p-3">
        <table class="table table-dark table-hover align-middle">
            <thead>
            <tr><th>Обложка</th><th>Название</th><th>Автор</th><th>Рейтинг</th><th>Действия</th></tr>
            </thead>
            <tbody>
            <?php foreach ($tracks as $track): ?>
                <tr>
                    <td><img src="uploads/<?= $track['image'] ?: 'default.png' ?>" class="track-img"></td>
                    <td><?= $track['title'] ?></td>
                    <td><a href="processing/author.process.php?id=<?= $track['author_id'] ?>" class="text-white">@<?= $track['author_name'] ?></a></td>
                    <td>⭐ <?= round($track['avg_rating'] ?? 0, 1) ?> (<?= $track['rating_count'] ?? 0 ?>)</td>
                    <td>
                        <a href="processing/show.process.php?id=<?= $track['id'] ?>" class="btn btn-sm btn-info">Просмотр</a>
                        <?php if (isset($_SESSION['user']) && ($_SESSION['user']['id'] == $track['author_id'] || $_SESSION['user']['role'] == 'admin')): ?>
                            <a href="processing/select.process.php?id=<?= $track['id'] ?>" class="btn btn-sm btn-purple">Изменить</a>
                            <a href="processing/delete.process.php?id=<?= $track['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Удалить?')">Удалить</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>