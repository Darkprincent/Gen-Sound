<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($track['title']) ?> - Gen Sound</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: radial-gradient(circle at center, #2e1065 0%, #0f051d 100%);
            color: white;
            min-height: 100vh;
        }
        .glass-card {
            background: rgba(20, 10, 40, 0.8);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            padding: 40px;
            margin-top: 50px;
            border: 1px solid rgba(106, 75, 194, 0.4);
            box-shadow: 0 0 40px rgba(0,0,0,0.5);
        }
        .full-cover {
            width: 100%;
            max-width: 300px;
            aspect-ratio: 1/1;
            object-fit: cover;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            border: 2px solid #6a4bc2;
        }
        .lyrics-text {
            white-space: pre-line;
            background: rgba(255, 255, 255, 0.05);
            padding: 25px;
            border-radius: 15px;
            border-left: 4px solid #6a4bc2;
            font-size: 1.1rem;
            line-height: 1.6;
        }
        .track-title { color: #d1b3ff; font-weight: 800; }
    </style>
</head>
<body>

<div class="container pb-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="glass-card">
                <div class="row align-items-center mb-5">
                    <div class="col-md-5 text-center mb-4 mb-md-0">
                        <img src="../uploads/<?= !empty($track['image']) ? htmlspecialchars($track['image']) : 'default.jpg' ?>"
                             class="full-cover" alt="Cover">
                    </div>
                    <div class="col-md-7">
                        <h1 class="track-title display-5 mb-2"><?= htmlspecialchars($track['title']) ?></h1>
                        <p class="lead text-info mb-4">Исполнитель: <b><?= htmlspecialchars($track['author_name']) ?></b></p>

                        <?php if (!empty($link)): ?>
                            <div class="mb-3">
                                <h6 class="text-white-50 small text-uppercase">Официальная ссылка:</h6>
                                <a href="<?= htmlspecialchars($link) ?>" target="_blank" class="btn btn-outline-info btn-sm">
                                    Открыть в плеере ↗
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="mt-4">
                    <h5 class="mb-3" style="color: #d1b3ff;">Текст песни</h5>
                    <div class="lyrics-text">
                        <?= !empty($track['lyric_text']) ? htmlspecialchars($track['lyric_text']) : '<i>Текст для этого трека еще не добавлен.</i>' ?>
                    </div>
                </div>

                <div class="mt-5 text-center border-top pt-4 border-secondary">
                    <a href="../index.php" class="btn btn-link text-white-50" style="text-decoration: none;">← Вернуться на главную</a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>