<?php
session_start();
require_once 'dbh.inc.php';

if (!isset($_SESSION['loggedInUser'])) {
    header('Location: loginpage.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['loggedInUser'];
    $animeId = $_POST['id'];
    $status = $_POST['status'];
    $score = $_POST['score'];
    $episodesWatched = $_POST['episodes_watched'];
    $startDate = $_POST['start_date'];
    $finishDate = $_POST['finish_date'];

    // Prepare the query
    $query = "INSERT INTO user_anime_list (user_id, anime_id, status, score, episodes_watched, start_date, finish_date)
              VALUES (:userId, :animeId, :status, :score, :episodesWatched, :startDate, :finishDate)
              ON DUPLICATE KEY UPDATE 
              status = VALUES(status), 
              score = VALUES(score), 
              episodes_watched = VALUES(episodes_watched), 
              start_date = VALUES(start_date), 
              finish_date = VALUES(finish_date)";

    try {
        $stmt = $pdo->prepare($query);
        
        // Bind parameters
        $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':animeId', $animeId, PDO::PARAM_INT);
        $stmt->bindValue(':status', $status, PDO::PARAM_STR);
        $stmt->bindValue(':score', $score, PDO::PARAM_INT);
        $stmt->bindValue(':episodesWatched', $episodesWatched, PDO::PARAM_INT);
        $stmt->bindValue(':startDate', $startDate, PDO::PARAM_STR);
        $stmt->bindValue(':finishDate', $finishDate, PDO::PARAM_STR);

        // Execute the query
        if ($stmt->execute()) {
            header('Location: collection.php');
            exit;
        } else {
            echo "Error: " . implode(" ", $stmt->errorInfo());
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>