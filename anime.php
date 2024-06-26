<?php
if (!isset($_GET['title'])) {
    die("Anime title is required");
}

$title = $_GET['title'];

// Gebruik de Jikan API om anime details op te halen
$apiUrl = "https://api.jikan.moe/v4/anime?q=" . urlencode($title);
$animeData = file_get_contents($apiUrl);
$animeData = json_decode($animeData, true);

if (isset($animeData['data'][0])) {
    $anime = $animeData['data'][0];
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
    <link rel="stylesheet" href="homecss.css">
    <style>
        html, body {
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

        .anime-detail h1, .anime-detail h2, .anime-detail p {
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
    </style>
</head>

<body>
    <header class="transparent-navbar text-white">
        <div class="container d-flex justify-content-between align-items-center py-2">
            <div class="logo">アニメ金庫</div>
            <nav class="d-flex">
                <a href="homepage.php" class="text-white mx-2">Home</a>
                <a href="#" class="text-white mx-2">Catalog</a>
                <a href="#" class="text-white mx-2">News</a>
            </nav>
            <div class="auth-buttons">
                <button class="btn btn-outline-light mx-2"><a href="loginpage.php">Login</a></button>
                <button class="btn btn-outline-light mx-2"><a href="signup.php">Get Started</a></button>
            </div>
        </div>
    </header>

    <main class="container anime-detail">
        <div class="row">
            <div class="col-md-4">
                <a href="homepage.php" class="btn btn-dark back-button">
                    <span>&#8592;</span> Terug naar Home
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
            </div>
        </div>
    </main>

    <footer class="bg-dark text-white text-center py-2">
        <div class="container">
            <a href="#" class="footer-link">アニメ金庫.com</a>
            <a href="#" class="footer-link">Terms & Privacy</a>
            <a href="#" class="footer-link">Contacts</a>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
