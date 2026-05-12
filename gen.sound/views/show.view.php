<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= $track['title'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #1a0a2e; color: white; min-height: 100vh; padding: 50px; }
        .glass-card { background: rgba(20,10,40,0.8); border-radius: 20px; padding: 40px; border: 1px solid #6a4bc2; }
        .cover-img { max-width: 300px; border-radius: 15px; border: 2px solid #6a4bc2; }
    </style>
</head>
<body>
<form action="../processing/rate.process.php" method="post" class="d-flex align-items-center gap-2">
    <input type="hidden" name="track_id" value="<?= $track['id'] ?>">
    <select name="rate" class="form-select w-auto">
        <option value="5">5 ⭐</option>
        <option value="4">4 ⭐</option>
        <option value="3">3 ⭐</option>
        <option value="2">2 ⭐</option>
        <option value="1">1 ⭐</option>
    </select>
    <button class="btn btn-warning btn-sm">Оценить</button>
</form>AA
<div class="container">
    <div class="glass-card">
        <div class="row">
            <div class="col-md-4 text-center">
                <img src="../uploads/<?= $track['image'] ?: 'default.jpg' ?>" class="cover-img img-fluid">
            </div>
            <div class="col-md-8">
                <h1 style="color: #d1b3ff;"><?= $track['title'] ?></h1>
                <p>Автор: <b><?= $track['author_name'] ?></b></p>
                <?php if ($track['link']): ?>
                    <a href="<?= $track['link'] ?>" target="_blank" class="btn btn-outline-info">Слушать ↗</a>
                <?php endif; ?>
                <hr class="border-secondary">
                <h5>Текст песни:</h5>
                <p class="text-white-50"><?= nl2br($track['lyric'] ?: '<i>Текст не добавлен</i>') ?></p>
            </div>
        </div>

        <div class="mt-4 text-center">
            <a href="../index.php" class="btn btn-purple">← На главную</a>
        </div>
    </div>
</div>
<style>.btn-purple { background: #6a4bc2; color: white; border: none; }</style>
</body>
</html>