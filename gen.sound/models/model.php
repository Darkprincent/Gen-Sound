<?php
// Подключение к БД
function addBD() {
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=gen.sound;charset=utf8mb4", 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Ошибка подключения: " . $e->getMessage());
    }
}

// Получение всех треков с авторами
function getAllTracks($pdo) {
    $query = "SELECT t.id, t.title, t.author_id, a.name as author_name, l.text as lyric_text, img.image 
              FROM tracks t
              JOIN authors a ON t.author_id = a.id
              LEFT JOIN lyrics l ON l.track_id = t.id
              LEFT JOIN images img ON img.track_id = t.id
              ORDER BY t.id DESC";
    return $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
}

// Добавление нового трека
function insTrack($pdo, $data) {
    $stmt = $pdo->prepare("INSERT INTO tracks (title, author_id) VALUES (:title, :author_id)");
    $stmt->execute([
        ':title' => $data['title'],
        ':author_id' => $data['author_id']
    ]);
    return $pdo->lastInsertId();
}

// Добавление текста к треку
function insLyrics($pdo, $text, $track_id) {
    $stmt = $pdo->prepare("INSERT INTO lyrics (text, track_id) VALUES (?, ?)");
    $stmt->execute([$text, $track_id]);
}
?>

<?php
// ... (предыдущие функции addBD, getAllTracks) ...

// Поиск пользователя для входа
function selUser($pdo, $name) {
    $stmt = $pdo->prepare("SELECT * FROM authors WHERE name = ?");
    $stmt->execute([$name]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Получение данных одного трека со всеми связями
function selTrackFull($pdo, $id) {
    $stmt = $pdo->prepare("
        SELECT t.*, a.name as author_name, l.text as lyric_text, img.image 
        FROM tracks t
        JOIN authors a ON t.author_id = a.id
        LEFT JOIN lyrics l ON l.track_id = t.id
        LEFT JOIN images img ON img.track_id = t.id
        WHERE t.id = ?
    ");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


// ... (существующие функции addBD, selUser, selTrackFull) ...

// Регистрация нового автора
function regUser($pdo, $name, $password)
{
    $stmt = $pdo->prepare("INSERT INTO authors (name, password, role) VALUES (?, ?, 'user')");
    $stmt->execute([$name, $password]);
    return $pdo->lastInsertId();
}

// Полное удаление трека и всех связей (текст, ссылки, фото)
function delTrack($pdo, $id)
{
    $pdo->prepare("DELETE FROM lyrics WHERE track_id = ?")->execute([$id]);
    $pdo->prepare("DELETE FROM links WHERE track_id = ?")->execute([$id]);
    $pdo->prepare("DELETE FROM images WHERE track_id = ?")->execute([$id]);
    $pdo->prepare("DELETE FROM tracks WHERE id = ?")->execute([$id]);
}

// Получение ссылки на трек из таблицы links
function getTrackLink($pdo, $track_id) {
    $stmt = $pdo->prepare("SELECT url FROM links WHERE track_id = ? LIMIT 1");
    $stmt->execute([$track_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Возвращаем только значение столбца 'url', если оно есть, иначе null
    return $result ? $result['url'] : null;
}


// ... (предыдущие функции) ...

// Обновление основного названия трека
function upd($pdo, $data) {
    // Если обложка не менялась, мы обновляем только текст и ссылки
    // Если пришла новая обложка, обновляем и её
    $sql = "UPDATE tracks SET 
            title = :title, 
            lyric_text = :text, 
            track_url = :link, 
            cover_url = :cover 
            WHERE id = :id";

    $stmt = $pdo->prepare($sql);
    return $stmt->execute($data);
}