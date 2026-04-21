<?php

// 1. ПОДКЛЮЧЕНИЕ К БАЗЕ ДАННЫХ
function addBD() {
    return new PDO("mysql:host=localhost;dbname=gen.sound;charset=utf8mb4", "root", "");
}

// 2. ПОЛУЧИТЬ ВСЕ ТРЕКИ (для главной страницы)
function getAllTracks($pdo) {
    $sql = "SELECT t.id, t.title, t.author_id, a.name as author_name, l.text as lyric_text, img.image 
            FROM tracks t
            JOIN authors a ON t.author_id = a.id
            LEFT JOIN lyrics l ON l.track_id = t.id
            LEFT JOIN images img ON img.track_id = t.id
            ORDER BY t.id DESC";

    $stmt = $pdo->prepare($sql);  // Готовим запрос
    $stmt->execute();              // Выполняем
    return $stmt->fetchAll();      // Забираем ВСЕ строки (массив)
}

// 3. НАЙТИ ПОЛЬЗОВАТЕЛЯ ПО ИМЕНИ (для входа)
function selUser($pdo, $name) {
    $stmt = $pdo->prepare("SELECT * FROM authors WHERE name = ?");
    $stmt->execute([$name]);       // ? заменяется на $name
    return $stmt->fetch();         // Забираем ОДНУ строку
}

// 4. ЗАРЕГИСТРИРОВАТЬ НОВОГО ПОЛЬЗОВАТЕЛЯ
function regUser($pdo, $name, $pass) {
    $stmt = $pdo->prepare("INSERT INTO authors (name, password, role) VALUES (?, ?, 'user')");
    $stmt->execute([$name, $pass]);
    return $pdo->lastInsertId();   // Возвращаем ID нового пользователя
}

// 5. ПОЛУЧИТЬ ОДИН ТРЕК СО ВСЕМИ ДАННЫМИ (для просмотра и редактирования)
function selTrackFull($pdo, $id) {
    $stmt = $pdo->prepare("SELECT t.*, a.name as author_name, l.text as lyric_text, img.image 
                           FROM tracks t
                           JOIN authors a ON t.author_id = a.id
                           LEFT JOIN lyrics l ON l.track_id = t.id
                           LEFT JOIN images img ON img.track_id = t.id
                           WHERE t.id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();         // Одна строка
}

// 6. ДОБАВИТЬ НОВЫЙ ТРЕК
function insTrack($pdo, $title, $author_id, $text, $link, $cover) {
    // Шаг 1: Вставляем в таблицу tracks
    $stmt = $pdo->prepare("INSERT INTO tracks (title, author_id) VALUES (?, ?)");
    $stmt->execute([$title, $author_id]);
    $trackId = $pdo->lastInsertId();  // Получаем ID созданного трека

    // Шаг 2: Вставляем текст в lyrics
    $pdo->prepare("INSERT INTO lyrics (track_id, text) VALUES (?, ?)")
        ->execute([$trackId, $text]);

    // Шаг 3: Вставляем ссылку в links
    $pdo->prepare("INSERT INTO links (track_id, url) VALUES (?, ?)")
        ->execute([$trackId, $link]);

    // Шаг 4: Вставляем имя фото в images
    $pdo->prepare("INSERT INTO images (track_id, image) VALUES (?, ?)")
        ->execute([$trackId, $cover]);
}

// 7. УДАЛИТЬ ТРЕК (и всё что с ним связано)
function delTrack($pdo, $id) {
    // Сначала получаем имя файла из БД
    $stmt = $pdo->prepare("SELECT image FROM images WHERE track_id = ?");
    $stmt->execute([$id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Если файл существует и это не default.jpg - удаляем
    if ($result && !empty($result['image']) && $result['image'] != 'default.jpg') {
        $filePath = '../uploads/' . $result['image'];
        if (file_exists($filePath)) {
            unlink($filePath);  // Удаляем файл
        }
    }

    // Удаляем записи из БД
    $pdo->prepare("DELETE FROM lyrics WHERE track_id = ?")->execute([$id]);
    $pdo->prepare("DELETE FROM links WHERE track_id = ?")->execute([$id]);
    $pdo->prepare("DELETE FROM images WHERE track_id = ?")->execute([$id]);
    $pdo->prepare("DELETE FROM tracks WHERE id = ?")->execute([$id]);
}

// 8. ОБНОВИТЬ ТРЕК
function updTrack($pdo, $id, $title, $text, $link, $cover) {
    // Если загрузили НОВОЕ фото - удаляем СТАРОЕ
    if ($cover != $_POST['old_cover'] && $_POST['old_cover'] != 'default.jpg') {
        $filePath = '../uploads/' . $_POST['old_cover'];
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    // Обновляем БД
    $pdo->prepare("UPDATE tracks SET title = ? WHERE id = ?")->execute([$title, $id]);
    $pdo->prepare("UPDATE lyrics SET text = ? WHERE track_id = ?")->execute([$text, $id]);
    $pdo->prepare("UPDATE links SET url = ? WHERE track_id = ?")->execute([$link, $id]);
    $pdo->prepare("UPDATE images SET image = ? WHERE track_id = ?")->execute([$cover, $id]);
}

// 9. ПОЛУЧИТЬ ССЫЛКУ НА ТРЕК
function getTrackLink($pdo, $id) {
    $stmt = $pdo->prepare("SELECT url FROM links WHERE track_id = ? LIMIT 1");
    $stmt->execute([$id]);
    $result = $stmt->fetch();

    // Если ссылка есть - вернуть её, если нет - вернуть null
    if ($result) {
        return $result['url'];
    } else {
        return null;
    }
}