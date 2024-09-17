<?php
session_start();
require_once 'dbh.inc.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['loggedInUser'];
    $malId = $_POST['id'];
    $status = $_POST['status'];
    $score = $_POST['score'];
    $episodesWatched = $_POST['episodes_watched'];
    $startDate = $_POST['start_date'];
    $finishDate = $_POST['finish_date'];

    try {
       
        $query = "INSERT INTO user_anime_list (user_id, mal_id, status, score, episodes_watched, start_date, finish_date)
          VALUES (:user_id, :mal_id, :status, :score, :episodes_watched, :start_date, :finish_date)
          ON DUPLICATE KEY UPDATE status = VALUES(status), score = VALUES(score), episodes_watched = VALUES(episodes_watched), start_date = VALUES(start_date), finish_date = VALUES(finish_date)";


        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':mal_id', $malId, PDO::PARAM_INT);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->bindParam(':score', $score, PDO::PARAM_INT);
        $stmt->bindParam(':episodes_watched', $episodesWatched, PDO::PARAM_INT);
        $stmt->bindParam(':start_date', $startDate, PDO::PARAM_STR);
        $stmt->bindParam(':finish_date', $finishDate, PDO::PARAM_STR);

       
        $stmt->execute();
        header('Location: collection.php');
        exit;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
