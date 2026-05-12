<?php
require_once "../models/model.php";

$pdo = addBD();
$author_id = $_GET['id'];

$author = $pdo->prepare("SELECT * FROM authors WHERE id = :id");
$author->execute(['id' => $author_id]);
$author = $author->fetch(PDO::FETCH_ASSOC);

$albums = getAuthorAlbums($pdo, $author_id);

$tracks = $pdo->prepare("SELECT tracks.*, albums.name AS album_name, 
                                 AVG(ratings.rate) AS avg_rating, COUNT(ratings.id) AS rating_count
                          FROM tracks 
                          LEFT JOIN albums ON tracks.album_id = albums.id 
                          LEFT JOIN ratings ON tracks.id = ratings.track_id
                          WHERE tracks.author_id = :author_id
                          GROUP BY tracks.id
                          ORDER BY tracks.id DESC");
$tracks->execute(['author_id' => $author_id]);
$tracks = $tracks->fetchAll(PDO::FETCH_ASSOC);

include "../views/author.view.php";