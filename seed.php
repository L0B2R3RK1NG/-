<?php

function fetchAnimeData()
{
    $animeData = file_get_contents('https://api.jikan.moe/v4/anime');

    return json_decode($animeData, true);
}

function createAnimeTable($pdo)
{
    $sql = 'CREATE TABLE IF NOT EXISTS anime (
        anime_id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        image_url VARCHAR(255) NOT NULL
    )';
    $pdo->exec($sql);
}

function storeAnimeData($animeList)
{
    $pdo = new PDO('mysql:host=localhost;dbname=anime', 'bit_academy', 'bit_academy');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    createAnimeTable($pdo);

    $stmt = $pdo->prepare('INSERT INTO anime (title, image_url) VALUES (:title, :image_url)');

    foreach ($animeList['data'] as $anime) {
        $stmt->execute([
            ':title' => $anime['title'],
            ':image_url' => $anime['images']['jpg']['image_url'],
        ]);
    }
}

$animeList = fetchAnimeData();
if (! empty($animeList['data'])) {
    storeAnimeData($animeList);
}

?>