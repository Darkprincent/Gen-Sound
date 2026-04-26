<?php

// 1. ПОДКЛЮЧЕНИЕ К БАЗЕ ДАННЫХ
function addBD() {
    return new PDO("mysql:host=localhost;dbname=gen.sound;charset=utf8mb4", "root", "");
}

// 2. ПОЛУЧИТЬ ВСЕ ТРЕКИ
function getAllTracks($pdo) {
    $stmt = $pdo->prepare("SELECT t.id, t.title, t.author_id, a.name as author_name, l.text as lyric_text, img.image 
                           FROM tracks t
                           JOIN authors a ON t.author_id = a.id
                           LEFT JOIN lyrics l ON l.track_id = t.id
                           LEFT JOIN images img ON img.track_id = t.id
                           ORDER BY t.id DESC");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// 3. НАЙТИ ПОЛЬЗОВАТЕЛЯ ПО ИМЕНИ
function selUser($pdo, $name) {
    $stmt = $pdo->prepare("SELECT * FROM authors WHERE name = :name");
    $stmt->execute(['name' => $name]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// 4. ЗАРЕГИСТРИРОВАТЬ ПОЛЬЗОВАТЕЛЯ
function regUser($pdo, $name, $pass) {
    $stmt = $pdo->prepare("INSERT INTO authors (name, password, role) VALUES (:name, :password, 'user')");
    $stmt->execute(['name' => $name, 'password' => $pass]);
    return $pdo->lastInsertId();
}

// 5. ПОЛУЧИТЬ ОДИН ТРЕК
function selTrackFull($pdo, $id) {
    $stmt = $pdo->prepare("SELECT t.*, a.name as author_name, l.text as lyric_text, img.image 
                           FROM tracks t
                           JOIN authors a ON t.author_id = a.id
                           LEFT JOIN lyrics l ON l.track_id = t.id
                           LEFT JOIN images img ON img.track_id = t.id
                           WHERE t.id = :id");
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// 6. ДОБАВИТЬ ТРЕК
function insTrack($pdo, $data) {
    $stmt = $pdo->prepare("INSERT INTO tracks (title, author_id) VALUES (:title, :author_id)");
    $stmt->execute(['title' => $data['title'], 'author_id' => $data['author_id']]);
    $trackId = $pdo->lastInsertId();
    $stmt = $pdo->prepare("INSERT INTO lyrics (track_id, text) VALUES (:track_id, :text)");
    $stmt->execute(['track_id' => $trackId, 'text' => $data['text']]);

    $stmt = $pdo->prepare("INSERT INTO links (track_id, url) VALUES (:track_id, :url)");
    $stmt->execute(['track_id' => $trackId, 'url' => $data['link']]);

    $stmt = $pdo->prepare("INSERT INTO images (track_id, image) VALUES (:track_id, :image)");
    $stmt->execute(['track_id' => $trackId, 'image' => $data['cover']]);
}

// 7. УДАЛИТЬ ТРЕК
function delTrack($pdo, $id) {
    $stmt = $pdo->prepare("SELECT image FROM images WHERE track_id = :id");
    $stmt->execute(['id' => $id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result && $result['image'] != 'default.jpg') {
        $filePath = '../uploads/' . $result['image'];
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }
    $stmt = $pdo->prepare("DELETE FROM lyrics WHERE track_id = :id");
    $stmt->execute(['id' => $id]);

    $stmt = $pdo->prepare("DELETE FROM links WHERE track_id = :id");
    $stmt->execute(['id' => $id]);

    $stmt = $pdo->prepare("DELETE FROM images WHERE track_id = :id");
    $stmt->execute(['id' => $id]);

    $stmt = $pdo->prepare("DELETE FROM tracks WHERE id = :id");
    $stmt->execute(['id' => $id]);
}

// 8. ОБНОВИТЬ ТРЕК
function updTrack($pdo, $data) {
    if ($data['cover'] != $data['old_cover'] && $data['old_cover'] != 'default.jpg') {
        $filePath = '../uploads/' . $data['old_cover'];
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }
    $stmt = $pdo->prepare("UPDATE tracks SET title = :title WHERE id = :id");
    $stmt->execute(['title' => $data['title'], 'id' => $data['id']]);

    $stmt = $pdo->prepare("UPDATE lyrics SET text = :text WHERE track_id = :id");
    $stmt->execute(['text' => $data['text'], 'id' => $data['id']]);

    $stmt = $pdo->prepare("UPDATE links SET url = :url WHERE track_id = :id");
    $stmt->execute(['url' => $data['link'], 'id' => $data['id']]);

    $stmt = $pdo->prepare("UPDATE images SET image = :image WHERE track_id = :id");
    $stmt->execute(['image' => $data['cover'], 'id' => $data['id']]);
}

// 9. ПОЛУЧИТЬ ССЫЛКУ
function getTrackLink($pdo, $id) {
    $stmt = $pdo->prepare("SELECT url FROM links WHERE track_id = :id LIMIT 1");
    $stmt->execute(['id' => $id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result ? $result['url'] : null;
}