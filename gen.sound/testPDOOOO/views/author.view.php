<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Автор - Gen Sound</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #1a0a2e; color: white; min-height: 100vh; }
        .table-glass { background: rgba(255,255,255,0.05); backdrop-filter: blur(10px); border-radius: 15px; }
        .btn-purple { background: #6a4bc2; color: white; }
        .star { color: gold; font-size: 20px; }
        .star-empty { color: #555; font-size: 20px; }
    </style>
</head>
<body class="p-5">
<div class="container">
    <h1 style="color: #d1b3ff;"><?= htmlspecialchars($author['name']) ?></h1>
    <a href="../index.php" class="btn btn-purple mb-4">← На главную</a>

    <!-- Кнопка создания альбома (только владелец или админ) -->
    <?php if (isset($_SESSION['user']) && ($_SESSION['user']['id'] == $author['id'] || $_SESSION['user']['role'] == 'admin')): ?>
        <div class="mb-4">
            <a href="../views/album_create.view.php" class="btn btn-success">➕ Создать альбом</a>
        </div>
    <?php endif; ?>

    <!-- АЛЬБОМЫ -->
    <h3 style="color: #d1b3ff;">Альбомы</h3>
    <?php if (!empty($albums)): ?>
        <div class="row mb-5">
            <?php foreach ($albums as $album): ?>
                <div class="col-md-3 mb-3">
                    <div class="card bg-dark text-white">
                        <img src="../uploads/<?= htmlspecialchars($album['image']) ?>" class="card-img-top" style="height: 150px; object-fit: cover;">
                        <div class="card-body">
                            <h5><?= htmlspecialchars($album['name']) ?></h5>
                            <p>Треков: <?= $album['track_count'] ?? 0 ?></p>
                            <a href="../processing/album.process.php?id=<?= $album['id'] ?>" class="btn btn-sm btn-purple">Открыть</a>

                            <!-- Кнопки изменения/удаления (владелец или админ) -->
                            <?php if (isset($_SESSION['user']) && ($_SESSION['user']['id'] == $author['id'] || $_SESSION['user']['role'] == 'admin')): ?>
                                <a href="../views/album_select.view.php?id=<?= $album['id'] ?>" class="btn btn-sm btn-warning">Изменить</a>
                                <a href="../processing/album.delete.process.php?id=<?= $album['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Удалить альбом? Все треки останутся без альбома.')">Удалить</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="text-white-50">Нет альбомов</p>
    <?php endif; ?>

    <!-- ТРЕКИ (без изменений, работают) -->
    <h3 style="color: #d1b3ff;">Треки</h3>
    <div class="table-responsive table-glass p-3">
        <table class="table table-dark table-hover align-middle mb-0">
            <thead>
            <tr><th>Обложка</th><th>Название</th><th>Альбом</th><th>Рейтинг</th><th>Оценка</th></tr>
            </thead>
            <tbody>
            <?php foreach ($tracks as $track): ?>
                <tr>
                    <td><img src="../uploads/<?= htmlspecialchars($track['image']) ?>" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;"></td>
                    <td><a href="../processing/show.process.php?id=<?= $track['id'] ?>" class="text-white text-decoration-none"><?= htmlspecialchars($track['title']) ?></a></td>
                    <td><?= htmlspecialchars($track['album_name'] ?? 'Сингл') ?></td>
                    <td>
                        <?php
                        $rating = round($track['avg_rating'] ?? 0);
                        for ($i = 1; $i <= 5; $i++):
                            echo ($i <= $rating) ? '⭐' : '☆';
                        endfor;
                        ?>
                        (<?= $track['rating_count'] ?? 0 ?>)
                    </td>
                    <td>
                        <?php if (isset($_SESSION['user'])): ?>
                            <form action="../processing/rate.process.php" method="post" class="d-flex gap-2">
                                <input type="hidden" name="track_id" value="<?= $track['id'] ?>">
                                <select name="rate" class="form-select form-select-sm" style="width: 70px;">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5" selected>5</option>
                                </select>
                                <button type="submit" class="btn btn-sm btn-purple">ОК</button>
                            </form>
                        <?php else: ?>
                            <span class="text-muted">Войдите, чтобы оценить</span>
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