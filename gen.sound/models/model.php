<?php

// Подключение к БД
function addBD(){
    return new PDO("mysql:host=localhost;dbname=gen.sound;charset=utf8mb4", "root", "");
}

//  ПОЛЬЗОВАТЕЛИ

function selUserName($pdo, $name){
    $stmt = $pdo->prepare("SELECT * FROM authors WHERE name = :name");
    $stmt->execute([':name' => $name]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function selUserId($pdo, $id){
    $stmt = $pdo->prepare("SELECT * FROM authors WHERE id = :id");
    $stmt->execute([':id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function insUser($pdo, $data){
    $sql = "INSERT INTO authors (name, password, role) VALUES (:name, :password, 'user')";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($data);
    return $pdo->lastInsertId();
}

//  ТРЕКИ

function selAllTracks($pdo){
    $stmt = $pdo->prepare("SELECT tracks.*, authors.name AS author_name,
                                  AVG(ratings.rate) AS avg_rating, COUNT(ratings.id) AS rating_count
                           FROM tracks 
                           JOIN authors ON tracks.author_id = authors.id 
                           LEFT JOIN ratings ON tracks.id = ratings.track_id
                           GROUP BY tracks.id
                           ORDER BY tracks.id DESC");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function selTrackId($pdo, $id){
    $stmt = $pdo->prepare("SELECT tracks.*, authors.name AS author_name
                           FROM tracks 
                           JOIN authors ON tracks.author_id = authors.id 
                           WHERE tracks.id = :id");
    $stmt->execute([':id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function insTrack($pdo, $data){
    $sql = "INSERT INTO tracks (title, author_id, image, lyric, link) 
            VALUES (:title, :author_id, :image, :lyric, :link)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($data);
}

function updTrack($pdo, $data){
    $sql = "UPDATE tracks SET title = :title, lyric = :lyric, link = :link, image = :image WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($data);
}

function delTrack($pdo, $id){
    // 1. Удаляем оценки (иначе внешний ключ не даст удалить трек)
    $stmt = $pdo->prepare("DELETE FROM ratings WHERE track_id = :id");
    $stmt->execute([':id' => $id]);

    // 2. Удаляем файл картинки
    $stmt = $pdo->prepare("SELECT image FROM tracks WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $track = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($track && $track['image'] != 'default.jpg') {
        $path = '../uploads/' . $track['image'];
        if (file_exists($path)) unlink($path);
    }

    // 3. Удаляем сам трек
    $stmt = $pdo->prepare("DELETE FROM tracks WHERE id = :id");
    $stmt->execute([':id' => $id]);
}

// ==================== АЛЬБОМЫ И АВТОРЫ ====================

function getAlbumById($pdo, $id) {
    $stmt = $pdo->prepare("SELECT albums.*, authors.name AS author_name 
                           FROM albums JOIN authors ON albums.author_id = authors.id 
                           WHERE albums.id = :id");
    $stmt->execute([':id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getAlbumTracks($pdo, $album_id) {
    $stmt = $pdo->prepare("SELECT tracks.*, AVG(ratings.rate) AS avg_rating 
                           FROM tracks 
                           LEFT JOIN ratings ON tracks.id = ratings.track_id
                           WHERE tracks.album_id = :album_id 
                           GROUP BY tracks.id");
    $stmt->execute([':album_id' => $album_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAuthorAlbums($pdo, $author_id) {
    $stmt = $pdo->prepare("SELECT * FROM albums WHERE author_id = :author_id");
    $stmt->execute([':author_id' => $author_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAuthorTracks($pdo, $author_id) {
    $stmt = $pdo->prepare("SELECT tracks.*, albums.name AS album_name, 
                                  AVG(ratings.rate) AS avg_rating, COUNT(ratings.id) AS rating_count
                           FROM tracks 
                           LEFT JOIN albums ON tracks.album_id = albums.id 
                           LEFT JOIN ratings ON tracks.id = ratings.track_id
                           WHERE tracks.author_id = :author_id
                           GROUP BY tracks.id
                           ORDER BY tracks.id DESC");
    $stmt->execute([':author_id' => $author_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function setRating($pdo, $data) {
    // Проверяем, ставил ли этот пользователь уже оценку этому треку
    $check = $pdo->prepare("SELECT id FROM ratings WHERE user_id = :user_id AND track_id = :track_id");
    $check->execute([':user_id' => $data[':user_id'], ':track_id' => $data[':track_id']]);
    $exists = $check->fetch();

    if ($exists) {
        // Если оценка есть — обновляем её
        $sql = "UPDATE ratings SET rate = :rate WHERE user_id = :user_id AND track_id = :track_id";
    } else {
        // Если нет — создаем новую
        $sql = "INSERT INTO ratings (rate, user_id, track_id) VALUES (:rate, :user_id, :track_id)";
    }
    $stmt = $pdo->prepare($sql);
    $stmt->execute($data);
}

// ==================== АЛЬБОМЫ (ALBUMS) ====================

// Создать альбом
function insAlbum($pdo, $data) {
    $sql = "INSERT INTO albums (name, image, author_id) VALUES (:name, :image, :author_id)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($data);
}

// Обновить альбом
function updAlbum($pdo, $data) {
    $sql = "UPDATE albums SET name = :name, image = :image WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($data);
}

// Удалить альбом
function delAlbum($pdo, $id) {
    // Важно: перед удалением альбома нужно отвязать от него треки (поставить им album_id = NULL)
    $stmt1 = $pdo->prepare("UPDATE tracks SET album_id = NULL WHERE album_id = :id");
    $stmt1->execute([':id' => $id]);

    $stmt2 = $pdo->prepare("DELETE FROM albums WHERE id = :id");
    $stmt2->execute([':id' => $id]);
}