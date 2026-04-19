<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($track['title']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('../612ca9583b4c11f1ade00a044bda6cd0.jpg') no-repeat center center fixed;
            background-size: cover;
            color: white;
        }
        .glass-card {
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 30px;
            margin-top: 50px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .lyrics-text {
            white-space: pre-line; /* Важно, чтобы сохранялись переносы строк текста */
            background: rgba(255, 255, 255, 0.05);
            padding: 20px;
            border-radius: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 glass-card">

            <div class="text-center mb-4">
                <?php if (!empty($track['image'])): ?>
                    <img src="data:image/jpeg;base64,<?= base64_encode($track['image']) ?>"
                         class="img-fluid rounded shadow mb-3" style="max-height: 300px;">
                <?php endif; ?>

                <h1><?= htmlspecialchars($track['title']) ?></h1>
                <p class="lead">Исполнитель: <b><?= htmlspecialchars($track['author_name']) ?></b></p>
            </div>

            <?php if ($link): ?>
                <div class="mt-4 p-3" style="background: rgba(255,255,255,0.1); border-radius: 10px;">
                    <h6 class="text-white-50">Официальная ссылка:</h6>
                    <a href="<?= htmlspecialchars($link) ?>" target="_blank" class="text-info" style="text-decoration: none; word-break: break-all;">
                        <?= htmlspecialchars($link) ?>
                    </a>
                </div>
            <?php endif; ?>

            <div class="mt-4">
                <h5>Текст песни:</h5>
                <div class="lyrics-text">
                    <?= htmlspecialchars($track['lyric_text'] ?? 'Текст не найден') ?>
                </div>
            </div>

            <?php if (!empty($track['url'])): ?>
                <div class="mt-4 p-3 border-top border-secondary">
                    <strong>Ссылка на трек:</strong> <br>
                    <a href="<?= htmlspecialchars($track['url']) ?>" target="_blank" class="text-info">
                        <?= htmlspecialchars($track['url']) ?>
                    </a>
                </div>
            <?php endif; ?>

            <div class="mt-4 text-center">
                <a href="../index.php" class="btn btn-outline-light">Назад к списку</a>
            </div>

        </div>
    </div>
</div>

</body>
</html>