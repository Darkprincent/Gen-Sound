<?php

// 1. ПОДКЛЮЧЕНИЕ К БАЗЕ ДАННЫХ
function addBD() {
    return new PDO("mysql:host=localhost;dbname=gen.sound;charset=utf8mb4", "root", "");
}

// 2. ПОЛУЧИТЬ ВСЕ ТРЕКИ
function getAllTracks($pdo) {
    $sql = "SELECT tracks.id, tracks.title, tracks.author_id, authors.name AS author_name, tracks.lyric, tracks.link, tracks.image 
            FROM tracks 
            JOIN authors ON tracks.author_id = authors.id 
            ORDER BY tracks.id DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// 3. НАЙТИ ПОЛЬЗОВАТЕЛЯ ПО ИМЕНИ
function selUser($pdo, $name) {
    $sql = "SELECT * FROM authors WHERE name = :name";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['name' => $name]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// 4. ЗАРЕГИСТРИРОВАТЬ ПОЛЬЗОВАТЕЛЯ
function regUser($pdo, $name, $pass) {
    $sql = "INSERT INTO authors (name, password, role) VALUES (:name, :password, 'user')";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['name' => $name, 'password' => $pass]);
    return $pdo->lastInsertId();
}

// 5. ПОЛУЧИТЬ ОДИН ТРЕК
function selTrackFull($pdo, $id) {
    $sql = "SELECT tracks.id, tracks.title, tracks.author_id, tracks.image, tracks.lyric, tracks.link, authors.name AS author_name 
            FROM tracks 
            JOIN authors ON tracks.author_id = authors.id 
            WHERE tracks.id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// 6. ДОБАВИТЬ ТРЕК
function insTrack($pdo, $data) {
    $sql = "INSERT INTO tracks (title, author_id, image, lyric, link) VALUES (:title, :author_id, :image, :lyric, :link)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'title'     => $data['title'],
        'author_id' => $data['author_id'],
        'image'     => $data['cover'],
        'lyric'     => $data['text'],
        'link'      => $data['link']
    ]);
}

// 7. УДАЛИТЬ ТРЕК
function delTrack($pdo, $id) {
    $sql = "SELECT image FROM tracks WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result && $result['image'] != 'default.jpg' && !empty($result['image'])) {
        $filePath = '../uploads/' . $result['image'];
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    $sql = "DELETE FROM tracks WHERE id = :id";
    $stmt = $pdo->prepare($sql);
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

    $sql = "UPDATE tracks SET title = :title, lyric = :lyric, link = :link, image = :image WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'title' => $data['title'],
        'lyric' => $data['text'],
        'link'  => $data['link'],
        'image' => $data['cover'],
        'id'    => $data['id']
    ]);
}

// 9. ПОЛУЧИТЬ ССЫЛКУ НА ТРЕК
function getTrackLink($pdo, $id) {
    $sql = "SELECT link FROM tracks WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result ? $result['link'] : null;
}