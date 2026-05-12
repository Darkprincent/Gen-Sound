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
        .star { color: gold; font-size: 24px; cursor: pointer; }
        .star-empty { color: #555; font-size: 24px; cursor: pointer; }
    </style>
</head>
<body class="p-5">
<div class="container">
    <h1 style="color: #d1b3ff;"><?= $author['name'] ?></h1>
<a href="../index.php" class="btn btn-purple mb-4">← На главную</a>

<!-- АЛЬБОМЫ -->
<h3 style="color: #d1b3ff;">Альбомы</h3>
<?php if (!empty($albums)): ?>
    <div class="row mb-5">
        <?php foreach ($albums as $album): ?>
            <div class="col-md-3 mb-3">
                <div class="card bg-dark text-white">
                    <img src="../uploads/<?= $album['image'] ?>" class="card-img-top" style="height: 150px; object-fit: cover;">
                    <div class="card-body">
                        <h5><?= $album['name'] ?></h5>
                        <p>Треков: <?= $album['track_count'] ?></p>
                        <a href="../processing/album.process.php?id=<?= $album['id'] ?>" class="btn btn-sm btn-purple">Открыть</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p class="text-white-50">Нет альбомов</p>
<?php endif; ?>

<!-- ТРЕКИ -->
<h3 style="color: #d1b3ff;">Треки</h3>
<div class="table-responsive table-glass p-3">
    <table class="table table-dark table-hover align-middle mb-0">
        <thead>
        <tr>
            <th>Обложка</th>
            <th>Название</th>
            <th>Альбом</th>
            <th>Рейтинг</th>
            <th>Оценка</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($tracks as $track): ?>
            <tr>
                <td>
                    <img src="../uploads/<?= $track['image'] ?>" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                </td>
                <td>
                    <a href="../processing/show.process.php?id=<?= $track['id'] ?>" class="text-white text-decoration-none">
                        <?= $track['title'] ?>
                    </a>
                </td>
                <td><?= $track['album_name'] ?? 'Сингл' ?></td>
               <td>
               <?php //$rating = round($track['avg_rating'] ?? 0); ?>
                <?php for ($i = 1; $i <= 5; $i++): ?>
                     <?php  $i <= $rating ? '⭐' : '☆' ?>
               <?php endfor; ?>
               (    <?php echo $track['rating_count'] ?? 0 ?> )
               </td>
            <td>
                   <form action="../processing/rate.process.php" method="post">-->
                   <input type="hidden" name="track_id" value="--><?php $track['id'] ?><!--">-->
                        <input type="hidden" name="author_id" value="--><?= $author['id'] ?><!--">-->
                     <select name="rate" class="form-select form-select-sm d-inline-block" style="width: 60px; background: #333; color: white; border: 1px solid #6a4bc2;">-->
                         <option value="1">1</option>-->
                           <option value="2">2</option>-->
                           <option value="3">3</option>-->
                            <option value="4">4</option>-->
                           <option value="5">5</option>-->
                        </select>
                        <button type="submit" class="btn btn-sm btn-purple">OK</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</div>
</body>
</html>