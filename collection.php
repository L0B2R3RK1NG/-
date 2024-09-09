<?php
session_start();
include("dbh.inc.php");


if (!isset($_SESSION['loggedInUser']) || empty($_SESSION['loggedInUser'])) {
    header("Location: loginpage.php");
}

$userId = $_SESSION['loggedInUser'];

$query = "SELECT anime_id, score, episodes_watched, status, start_date, finish_date FROM user_anime_list WHERE user_id = $userId";
$result = mysqli_query($conn, $query);

$savedAnime = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $animeId = $row['anime_id'];
        $score = $row['score'];
        $episodes_watched = $row['episodes_watched'];
        $status = $row['status'];
        $start_date = $row['start_date'];
        $finish_date = $row['finish_date'];


        $animeQuery = "SELECT title, image_url FROM anime WHERE anime_id = $animeId";
        $animeResult = mysqli_query($conn, $animeQuery);

        if ($animeResult && mysqli_num_rows($animeResult) > 0) {
            $animeRow = mysqli_fetch_assoc($animeResult);


            $savedAnime[] = [
                'title' => $animeRow['title'],
                'image_url' => $animeRow['image_url'],
                'score' => $score,
                'episodes_watched' => $episodes_watched,
                'status' => $status,
                'start_date' => $start_date,
                'finish_date' => $finish_date
            ];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saved Anime Collection</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css/colletionsstyle.css">

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
                        $loggedin = $_SESSION['loggedInUser'];
                        $query = "SELECT username, profile_pic FROM users WHERE user_id = ?";
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param('i', $loggedin);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result && $result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $username = $row['username'];
                            $profilePhoto = $row['profile_pic'];

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
                                        <p><strong>episodes:</strong> <?php echo htmlspecialchars($anime['episodes_watched']); ?></p>
                                        <p><strong>Status:</strong> <?php echo htmlspecialchars($anime['status']); ?></p>
                                        <p><strong>start_date:</strong> <?php echo htmlspecialchars($anime['start_date']); ?></p>
                                        <p><strong>finish_date:</strong> <?php echo htmlspecialchars($anime['finish_date']); ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <p class="text-white">Er zijn geen opgeslagen anime.</p>
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

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>