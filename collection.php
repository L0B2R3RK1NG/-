<?php
session_start();
include("dbh.inc.php"); // Inclusief bestand voor databaseverbinding

// Controleer of de gebruiker is ingelogd
if (!isset($_SESSION['loggedInUser']) || empty($_SESSION['loggedInUser'])) {
    header("Location: loginpage.php"); // Stuur niet-ingelogde gebruikers naar de loginpagina
    exit;
}

// Haal de `user_id` van de ingelogde gebruiker op
$userId = $_SESSION['loggedInUser'];

// Query om de anime_id's op te halen uit de `user_anime_list`-tabel
$query = "SELECT anime_id FROM user_anime_list WHERE user_id = $userId";
$result = mysqli_query($conn, $query);

// Array om opgeslagen anime ID's op te slaan
$savedAnimeIds = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $savedAnimeIds[] = $row['anime_id'];
    }
}

// Array om anime details op te slaan
$savedAnime = [];
if (!empty($savedAnimeIds)) {
    foreach ($savedAnimeIds as $animeId) {
        $query = "SELECT title, image_url FROM anime WHERE anime_id = $animeId";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $savedAnime[] = $row;
            }
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
    <link rel="stylesheet" href="homecss.css">
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
        }

        main {
            flex: 1;
        }

        body {
            background-color: #212121;
        }

        .transparent-navbar {
            background: transparent;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }

        .anime-detail {
            margin-top: 80px;
            color: white;
        }

        .anime-detail img {
            width: 100%;
            height: auto;
        }

        .anime-detail .description {
            margin-top: 20px;
        }

        .anime-detail h1,
        .anime-detail h2,
        .anime-detail p {
            color: white;
        }

        .back-button {
            display: inline-flex;
            align-items: center;
            margin-bottom: 10px;
            color: white;
            text-decoration: none;
            font-size: 1rem;
        }

        .back-button span {
            font-size: 1rem;
            margin-right: 8px;
        }

        .back-button:hover {
            text-decoration: underline;
        }

        footer {
            background-color: #343a40;
            color: white;
            padding: 10px 0;
        }

        .footer-link {
            color: white;
            margin: 0 10px;
        }

        .footer-link:hover {
            text-decoration: underline;
        }

        a:visited {
            color: white;
            background-color: transparent;
            text-decoration: none;
        }

        a:hover {
            color: black;
            background-color: transparent;
            text-decoration: none;
        }

        .add-to-list-btn {
            background-color: green;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            margin-top: 20px;
        }

        .modal-content {
            background-color: #212121;
            color: white;
        }

        .form-container h2,
        .form-container label {
            color: white;
        }

        .form-container .form-control {
            background-color: #343a40;
            color: white;
            border: 1px solid #495057;
        }

        .form-container .btn-primary {
            background-color: green;
            border-color: green;
        }

        .modal-header img {
            width: 200px;
            height: auto;
            margin-right: 10px;
        }

        .modal-title {
            display: flex;
            align-self: flex-end;
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
                <a href="#" class="text-white mx-2">News</a>
            </nav>
            <div class="auth-buttons">
                <?php if (isset($_SESSION['loggedInUser']) && !empty($_SESSION['loggedInUser'])) : ?>
                    <div class="dropdown profile-section">
                        <?php
                        // Query to get the profile photo of the logged-in user
                        $userId = $_SESSION['loggedInUser'];
                        $query = "SELECT username, profile_pic FROM users WHERE user_id = $userId";
                        $result = mysqli_query($conn, $query);

                        if ($result && mysqli_num_rows($result) > 0) {
                            $row = mysqli_fetch_assoc($result);
                            $profilePhoto = $row['profile_pic'];
                            echo '<img src="' . $profilePhoto . '" alt="Profielfoto" class="rounded-circle dropdown-toggle" width="30" height="30" type="button" data-bs-toggle="dropdown" aria-expanded="false">';
                            echo '<div class="dropdown-menu dropdown-menu-dark">';
                            echo '<li><a class="dropdown-item" href="#">' . htmlspecialchars($username) . '</a></li>';
                            echo '<div class="dropdown-divider"></div>';
                            echo '<li><a class="dropdown-item" href="#">Settings</a></li>';
                            echo '<div class="dropdown-divider"></div>';
                            echo '<li><a class="dropdown-item" href="logout.php">Logout</a></li>';
                            echo '</div>';
                        } else {
                            echo '<img src="standaard_profielfoto.jpg" alt="Profielfoto" class="rounded-circle dropdown-toggle" width="30" height="30" type="button" data-bs-toggle="dropdown" aria-expanded="false">';
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
                                        <p><strong>Episodes:</strong> <?php echo htmlspecialchars($anime['episodes']); ?></p>
                                        <p><strong>Status:</strong> <?php echo htmlspecialchars($anime['status']); ?></p>
                                        <p><strong>Aired:</strong> <?php echo htmlspecialchars($anime['aired']); ?></p>
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

    <footer class="bg-dark text-white text-center py-3">
        <!-- Je voettekst zoals op de anime-pagina -->
    </footer>

    <!-- JavaScript en jQuery zoals op de anime-pagina -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>