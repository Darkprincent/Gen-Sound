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

        /* Шапка профиля */
        .auth-bar {
            background: rgba(255, 255, 255, 0.07);
            padding: 15px 25px;
            border-radius: 15px;
            margin-bottom: 30px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        a { text-decoration: none; }
    </style>
</head>
<body class="p-5">
<div class="container">

    <div class="auth-bar d-flex justify-content-between align-items-center">
        <h2 style="color: #d1b3ff; margin: 0; font-weight: bold; text-shadow: 0 0 10px rgba(209, 179, 255, 0.3);">Gen Sound</h2>
        <div>
            <?php if (isset($_SESSION['user'])): ?>
                <span class="me-3">Привет, <b class="text-info"><?= htmlspecialchars($_SESSION['user']['name']) ?></b></span>
                <a href="processing/logout.process.php" class="btn btn-outline-danger btn-sm">Выйти</a>
            <?php else: ?>
                <a href="views/login.view.php" class="btn btn-outline-info btn-sm me-2">Вход</a>
                <a href="views/register.view.php" class="btn btn-purple btn-sm">Регистрация</a>
            <?php endif; ?>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-white-50">Музыкальная база</h3>

        <?php if (isset($_SESSION['user'])): ?>
            <a href="views/create.view.php" class="btn btn-success shadow-sm fw-bold">+ Добавить трек</a>
        <?php else: ?>
            <span class="badge bg-warning text-dark">Войдите, чтобы добавлять треки</span>
        <?php endif; ?>
    </div>

    <div class="table-responsive table-glass p-3">
        <table class="table table-borderless align-middle mb-0 text-white">
            <thead>
            <tr style="border-bottom: 2px solid #6a4bc2;">
                <th>Название трека</th>
                <th>Автор</th>
                <th class="text-center">Действия</th>
            </tr>
            </thead>
            <tbody>
            <?php if (!empty($tracks)): ?>
                <?php foreach ($tracks as $track): ?>
                    <tr>
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
                <tr><td colspan="3" class="text-center p-5 text-white-50">Список пуст. Станьте первым, кто добавит трек!</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>