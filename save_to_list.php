<?php
session_start();
require_once 'dbh.inc.php';

if (!isset($_SESSION['loggedInUser'])) {
    // Redirect to login page if not logged in
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

    // Prepare the SQL statement to insert or update the user's anime list
    $query = "INSERT INTO user_anime_list (user_id, anime_id, status, score, episodes_watched, start_date, finish_date)
              VALUES (?, ?, ?, ?, ?, ?, ?)
              ON DUPLICATE KEY UPDATE status = VALUES(status), score = VALUES(score), episodes_watched = VALUES(episodes_watched), start_date = VALUES(start_date), finish_date = VALUES(finish_date)";

    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param('iisiiss', $userId, $animeId, $status, $score, $episodesWatched, $startDate, $finishDate);
        if ($stmt->execute()) {
            header('Location: collection.php');
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>
