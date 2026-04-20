<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Gen Sound - Главная</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1a0a2e 0%, #3b1c71 100%);
            color: white;
            min-height: 100vh;
        }
        .table-glass {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .btn-purple { background: #6a4bc2; color: white; border: none; }
        .btn-purple:hover { background: #8261e1; color: white; }
        .track-img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid rgba(211, 179, 255, 0.3);
        }
    </style>
</head>
<body class="p-5">
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 style="color: #d1b3ff; font-weight: 800; letter-spacing: -1px;">GEN SOUND</h1>
        <?php if (isset($_SESSION['user'])): ?>
            <div class="d-flex align-items-center gap-3">
                <span>Привет, <b><?= htmlspecialchars($_SESSION['user']['name']) ?></b></span>
                <a href="views/create.view.php" class="btn btn-purple">+ Добавить трек</a>
                <a href="processing/logout.process.php" class="btn btn-outline-danger btn-sm">Выход</a>
            </div>
        <?php else: ?>
            <a href="views/login.view.php" class="btn btn-purple px-4">Войти</a>
            <?php subtitle: endif; ?>
    </div>

    <div class="table-responsive table-glass p-3">
        <table class="table table-dark table-hover align-middle mb-0">
            <thead>
            <tr>
                <th style="width: 70px;"></th> <th>Название</th>
                <th>Автор</th>
                <th class="text-center">Действия</th>
            </tr>
            </thead>
            <tbody>
            <?php if (!empty($tracks)): ?>
                <?php foreach ($tracks as $track): ?>
                    <tr>
                        <td>
                            <img src="uploads/<?= !empty($track['image']) ? htmlspecialchars($track['image']) : 'default.jpg' ?>"
                                 alt="cover" class="track-img">
                        </td>
                        <td class="fw-bold"><?= htmlspecialchars($track['title']) ?></td>
                        <td><span class="text-info">@</span><?= htmlspecialchars($track['author_name']) ?></td>
                        <td class="text-center">
                            <a href="processing/show.process.php?id=<?= $track['id'] ?>" class="btn btn-sm btn-info">👁 Просмотр</a>
                            <?php if (isset($_SESSION['user']) && ($_SESSION['user']['id'] == $track['author_id'] || $_SESSION['user']['role'] === 'admin')): ?>
                                <a href="processing/select.process.php?id=<?= $track['id'] ?>" class="btn btn-sm btn-purple">📝</a>
                                <a href="processing/delete.process.php?id=<?= $track['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Удалить?')">🗑</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="4" class="text-center p-5 text-white-50">Треков пока нет...</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>