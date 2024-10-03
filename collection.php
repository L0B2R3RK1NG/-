<?php
session_start();
require_once 'dbh.inc.php';

$userId = $_SESSION['loggedInUser'];

try {
    $query = "SELECT mal_id, score, episodes_watched, status, start_date, finish_date FROM user_anime_list WHERE user_id = :user_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->execute();

    $savedAnime = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $malId = $row['mal_id'];
        $score = $row['score'];
        $episodes_watched = $row['episodes_watched'];
        $status = $row['status'];
        $start_date = $row['start_date'];
        $finish_date = $row['finish_date'];

        $apiUrl = "https://api.jikan.moe/v4/anime/" . $malId;
        $animeData = file_get_contents($apiUrl);
        $anime = json_decode($animeData, true)['data'];

        if ($anime) {
            $savedAnime[] = [
                'title' => $anime['title'],
                'image_url' => $anime['images']['jpg']['large_image_url'],
                'score' => $score,
                'episodes_watched' => $episodes_watched,
                'status' => $status,
                'start_date' => $start_date,
                'finish_date' => $finish_date
            ];
        }
    }

    if (empty($savedAnime)) {
        $noAnimeMessage = "Er zijn geen opgeslagen anime.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saved Anime Collection</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style/colletionsstyle.css">
    <style>
        h1
        {
            margin-top: 10%;
        }

        .no-anime-message {
            color: #fff;
            background-color: rgba(0, 0, 0, 0.7);
            padding: 20px;
            border-radius: 5px;
            text-align: center;
            font-size: 1.5rem;
            margin-top: 50px;
        }

        .anime-detail {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
        }

        .anime-detail h1 {
            color: #ffcc00;
            margin-bottom: 30px;
            text-align: center;
        }

        .card-body {
            background-color: #212121;
            color: #fff;
            padding: 20px;
        }

        .card-title {
            color: #fff;
        }

        .card-body p {
            color: #fff;
        }

        .card-body strong {
            color: #ff0;
        }

        .dropdown-menu {
            background-color: #343a40;
            border: 1px solid #495057;

        }

        .dropdown-item {
            color: #ffffff;
        }

        .dropdown-item:hover {
            background-color: #495057;
        }

        .dropdown-menu-dark {
            background-color: #343a40;
        }

        .dropdown-toggle::after {
            display: none;
        }

        body
        {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        footer
        {
            padding: 20px;
            margin-top: auto;
        }
    </style>
</head>

<body>
    <header class="transparent-navbar text-white">
        <div class="container d-flex justify-content-between align-items-center py-2">
            <div class="logo">アニメ金庫</div>
            <nav class="d-flex">
                <a href="homepage.php" class="text-white mx-2">Home</a>
                <a href="catalog.php" class="text-white mx-2">Catalog</a>
            </nav>
            <div class="auth-buttons">
                <?php if (isset($_SESSION['loggedInUser']) && !empty($_SESSION['loggedInUser'])) : ?>
                    <div class="dropdown profile-section">
                        <?php
                        $loggedin = $_SESSION['loggedInUser'];
                        $query = "SELECT username, profile_pic FROM users WHERE user_id = :user_id";
                        $stmt = $pdo->prepare($query);
                        $stmt->bindParam(':user_id', $loggedin, PDO::PARAM_INT);
                        $stmt->execute();
                        $result = $stmt->fetch(PDO::FETCH_ASSOC);

                        if ($result) {
                            $username = $result['username'];
                            $profilePhoto = $result['profile_pic'];

                            if (!empty($profilePhoto)) {
                                echo '<img src="' . htmlspecialchars($profilePhoto) . '" alt="Profielfoto" class="rounded-circle dropdown-toggle" width="30" height="30" type="button" data-bs-toggle="dropdown" aria-expanded="false">';
                            } else {
                                echo '<button class="btn btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">' . htmlspecialchars($username) . '</button>';
                            }

                            echo '<div class="dropdown-menu dropdown-menu-dark">';
                            echo '<li><a class="dropdown-item" href="#">' . htmlspecialchars($username) . '</a></li>';
                            echo '<div class="dropdown-divider"></div>';
                            echo '<li><a class="dropdown-item" href="collection.php">Collection</a></li>';
                            echo '<div class="dropdown-divider"></div>';
                            echo '<li><a class="dropdown-item" href="logout.php">Logout</a></li>';
                            echo '</div>';
                        }
                        ?>
                    </div>
                <?php else : ?>
                    <button class="btn btn-outline-light mx-2"><a href="loginpage.php">Login</a></button>
                    <button class="btn btn-outline-light mx-2"><a href="signup.php">Get Started</a></button>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <main class="container anime-detail">
        <div class="row">
            <div class="col-md-12">
                <h1>Saved Anime Collection</h1>
                <div class="row">
                    <?php if (!empty($savedAnime)) : ?>
                        <?php foreach ($savedAnime as $anime) : ?>
                            <div class="col-md-4 mb-4">
                                <div class="card">
                                    <img src="<?php echo htmlspecialchars($anime['image_url']); ?>" class="card-img-top" alt="Anime Image">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo htmlspecialchars($anime['title']); ?></h5>
                                        <p><strong>Score:</strong> <?php echo htmlspecialchars($anime['score']); ?></p>
                                        <p><strong>Episodes:</strong> <?php echo htmlspecialchars($anime['episodes_watched']); ?></p>
                                        <p><strong>Status:</strong> <?php echo htmlspecialchars($anime['status']); ?></p>
                                        <p><strong>Start Date:</strong> <?php echo htmlspecialchars($anime['start_date']); ?></p>
                                        <p><strong>Finish Date:</strong> <?php echo htmlspecialchars($anime['finish_date']); ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <div class="no-anime-message">
                            <p>Er zijn geen opgeslagen anime.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>

    <footer class="bg-dark text-white text-center py-2">
        <div class="container">
            <a href="#" class="text-white mx-2">アニメ金庫.com</a>
            <a href="#" class="text-white mx-2">Terms & Privacy</a>
            <a href="#" class="text-white mx-2">Contacts</a>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
