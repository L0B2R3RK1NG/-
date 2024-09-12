<?php
session_start();
include("dbh.inc.php");

if (!isset($_GET['title'])) {
    die("Anime title is required");
}

$title = $_GET['title'];

// Anime ophalen via de Jikan API
$apiUrl = "https://api.jikan.moe/v4/anime?q=" . urlencode($title);
$animeData = file_get_contents($apiUrl);
$animeData = json_decode($animeData, true);

if (isset($animeData['data'][0])) {
    $anime = $animeData['data'][0];
    $malId = $anime['mal_id'];
} else {
    die("Anime not found");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($anime['title']); ?> - アニメ金庫</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css/animestyle.css">
</head>

<body>
    <header class="transparent-navbar text-white">
        <div class="container d-flex justify-content-between align-items-center py-2">
            <div class="logo">アニメ金庫</div>
            <nav class="d-flex">
                <a href="homepage.php" class="text-white mx-2">Home</a>
                <a href="catalog.php" class="text-white mx-2">Catalog</a>
                <a href="#" class="text-white mx-2">News</a>
            </nav>
            <div class="auth-buttons">
                <?php if (isset($_SESSION['loggedInUser']) && !empty($_SESSION['loggedInUser'])) : ?>
                    <div class="dropdown profile-section">
                        <?php
                        $pdo = new PDO('mysql:host=localhost;dbname=anime', 'bit_academy', 'bit_academy');
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                        $loggedin = $_SESSION['loggedInUser'];
                        $query = "SELECT username, profile_pic FROM users WHERE user_id = :loggedin";
                        $stmt = $pdo->prepare($query);
                        $stmt->bindParam(':loggedin', $loggedin, PDO::PARAM_INT);
                        $stmt->execute();
                        $result = $stmt->fetch(PDO::FETCH_ASSOC);

                        if ($result) {
                            $username = htmlspecialchars($result['username']);
                            $profilePhoto = htmlspecialchars($result['profile_pic']);

                            if (!empty($profilePhoto)) {
                                echo '<img src="' . $profilePhoto . '" alt="Profielfoto" class="rounded-circle dropdown-toggle" width="30" height="30" data-bs-toggle="dropdown" aria-expanded="false">';
                            } else {
                                echo '<button class="btn btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">' . $username . '</button>';
                            }

                            echo '<ul class="dropdown-menu dropdown-menu-dark">';
                            echo '<li><a class="dropdown-item" href="#">' . $username . '</a></li>';
                            echo '<li><hr class="dropdown-divider"></li>';
                            echo '<li><a class="dropdown-item" href="collection.php">Collection</a></li>';
                            echo '<li><hr class="dropdown-divider"></li>';
                            echo '<li><a class="dropdown-item" href="logout.php">Logout</a></li>';
                            echo '</ul>';
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
            <div class="col-md-4">
                <a href="homepage.php" class="btn btn-dark back-button">
                    <span>&#8592;</span> Back to Home
                </a>
                <img src="<?php echo htmlspecialchars($anime['images']['jpg']['large_image_url']); ?>" alt="<?php echo htmlspecialchars($anime['title']); ?>">
            </div>
            <div class="col-md-8">
                <h1><?php echo htmlspecialchars($anime['title']); ?></h1>
                <h2><?php echo htmlspecialchars($anime['title_japanese']); ?></h2>
                <p><?php echo htmlspecialchars($anime['synopsis']); ?></p>
                <p><strong>Score:</strong> <?php echo htmlspecialchars($anime['score']); ?></p>
                <p><strong>Episodes:</strong> <?php echo htmlspecialchars($anime['episodes']); ?></p>
                <p><strong>Status:</strong> <?php echo htmlspecialchars($anime['status']); ?></p>
                <p><strong>Aired:</strong> <?php echo htmlspecialchars($anime['aired']['string']); ?></p>
                <?php if (isset($_SESSION['loggedInUser']) && !empty($_SESSION['loggedInUser'])) : ?>

                    <button type="button" class="add-to-list-btn" data-toggle="modal" data-target="#addToListModal">
                        Add to List
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </main>


    <div class="modal fade" id="addToListModal" tabindex="-1" aria-labelledby="addToListModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <img src="<?php echo htmlspecialchars($anime['images']['jpg']['large_image_url']); ?>" alt="<?php echo htmlspecialchars($anime['title']); ?>">
                    <h5 class="modal-title" id="addToListModalLabel"><?php echo htmlspecialchars($anime['title']); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="save_to_list.php" method="post">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($anime['mal_id']); ?>">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="Plan to Watch">Plan to Watch</option>
                                <option value="Watching">Watching</option>
                                <option value="Completed">Completed</option>
                                <option value="On Hold">On Hold</option>
                                <option value="Dropped">Dropped</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="score">Score</label>
                            <input type="number" name="score" id="score" class="form-control" min="1" max="10">
                        </div>
                        <div class="form-group">
                            <label for="episodes_watched">Episodes Watched</label>
                            <input type="number" name="episodes_watched" id="episodes_watched" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="start_date">Start Date</label>
                            <input type="date" name="start_date" id="start_date" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="finish_date">Finish Date</label>
                            <input type="date" name="finish_date" id="finish_date" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-dark text-white text-center py-2">
        <div class="container">
            <a href="#" class="text-white mx-2">アニメ金庫.com</a>
            <a href="#" class="text-white mx-2">Terms & Privacy</a>
            <a href="#" class="text-white mx-2">Contacts</a>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>