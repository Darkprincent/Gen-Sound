<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= $album['name'] ?> - Gen Sound</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #1a0a2e; color: white; min-height: 100vh; }
        .btn-purple { background: #6a4bc2; color: white; }
    </style>
</head>
<body class="p-5">
<div class="container">
    <h1 style="color: #d1b3ff;"><?= $album['name'] ?></h1>
    <p>Автор: <?= $album['author_name'] ?></p>
    <a href="../index.php" class="btn btn-purple mb-4">← На главную</a>

    <div class="row">
        <?php foreach ($tracks as $track): ?>
            <div class="col-md-4 mb-3">
                <div class="card bg-dark text-white">
                    <img src="../uploads/<?= $track['image'] ?>" class="card-img-top" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5><?= $track['title'] ?></h5>
                        <p>⭐ <?= round($track['avg_rating'] ?? 0, 1) ?></p>
                        <a href="../processing/show.process.php?id=<?= $track['id'] ?>" class="btn btn-sm btn-purple">Смотреть</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>