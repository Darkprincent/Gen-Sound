<?php
session_start();
$host = '127.0.0.1';
$db   = 'gen.sound';
$user = 'root';
$pass = '';
$pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);

$id = $_GET['id'] ?? 0;

// Собираем все данные о треке через JOIN
$stmt = $pdo->prepare("
    SELECT t.*, a.name as author_name, l.text, lnk.url, img.image 
    FROM tracks t
    JOIN authors a ON t.author_id = a.id
    LEFT JOIN lyrics l ON l.track_id = t.id
    LEFT JOIN links lnk ON lnk.track_id = t.id
    LEFT JOIN images img ON img.track_id = t.id
    WHERE t.id = ?
");
$stmt->execute([$id]);
$track = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$track) {
    die("Песня не найдена.");
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($track['title']) ?> - Gen Sound</title>
    <style>
        body { font-family: sans-serif; line-height: 1.6; background: #fff; color: #333; padding: 40px; }
        .container { max-width: 600px; margin: auto; }
        .header { text-align: center; margin-bottom: 30px; }
        .cover { width: 100%; max-height: 400px; object-fit: cover; border-radius: 8px; margin-bottom: 20px; }
        .lyrics { white-space: pre-line; background: #f9f9f9; padding: 20px; border-left: 4px solid #007bff; }
        .back-link { display: block; margin-top: 30px; color: #007bff; text-decoration: none; }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1><?= htmlspecialchars($track['title']) ?></h1>
        <p>Исполнитель: <b><?= htmlspecialchars($track['author_name']) ?></b></p>
    </div>

    <?php if ($track['image']): ?>
        <img src="data:image/jpeg;base64,<?= base64_encode($track['image']) ?>" class="cover">
    <?php endif; ?>

    <h3>Текст песни</h3>
    <div class="lyrics">
        <?= nl2br(htmlspecialchars($track['text'] ?? 'Текст еще не добавлен.')) ?>
    </div>

    <?php if ($track['url']): ?>
        <p style="margin-top: 20px;">
            🔗 <b>Ссылка:</b> <a href="<?= htmlspecialchars($track['url']) ?>" target="_blank">Перейти к ресурсу</a>
        </p>
    <?php endif; ?>

    <a href="index.php" class="back-link">← Вернуться к списку</a>
</div>

</body>
</html>